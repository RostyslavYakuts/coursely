<?php

namespace coursely\App\Core\Handlers;

use coursely\App\Core\Helpers\CheckoutHelper;
use coursely\App\Core\Helpers\UserIpDetector;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;
use coursely\App\Core\Helpers\NonceChecker;
use coursely\App\Core\Helpers\RecaptchaChecker;

class AjaxCheckout
{
    public function __construct()
    {
        add_action('wp_ajax_checkout_action', [$this, 'handle']);
        add_action('wp_ajax_nopriv_checkout_action', [$this, 'handle']);
    }
    public function handle(): void
    {
        if ( ! is_user_logged_in() ) {
            $user_identifier = UserIpDetector::get_client_ip();
            $rate_limit_key = 'strp_sub_checkout_limit_' . md5( $user_identifier );

            if ( get_transient( $rate_limit_key ) ) {
                error_log( 'Rate limit triggered for guest identifier: ' . substr( hash( 'sha256', $user_identifier ), 0, 12 ) );
                wp_send_json_error( array(
                    'message' => __( 'You are trying to start a new payment too quickly. Please wait a moment and try again.', 'coursely' )
                ) );
                return;
            }

            // Set rate limit (10 seconds cooldown for guests only)
            set_transient( $rate_limit_key, true, 10 );
        }



        try {
            NonceChecker::check('checkout_action');
            RecaptchaChecker::check();
            $data = CheckoutHelper::getRequestData();
            $userId = get_current_user_id();
            CheckoutHelper::validateRequest($data,$userId);
            $stripe = CheckoutHelper::getStripeClient();
            $plan = CheckoutHelper::getPlanByPlanId($data['plan_id']);
            $signupToken = CheckoutHelper::createSignupToken($data);
            $customer = $this->getOrCreateCustomer($stripe, $data, $userId);
            $this->attachPaymentMethod($stripe, $data['payment_method_id'], $customer->id);
            $customer = $stripe->customers->retrieve($customer->id);
            $activeSub = $this->getActiveSubscription($stripe, $customer->id);

            $needsUpdate = false;

            // Case user already has this plan as active subscription
            if ($activeSub){
                if(CheckoutHelper::isSamePlan($activeSub, $plan['stripe_price_id'])) {
                    if ($activeSub->cancel_at_period_end) {
                        $needsUpdate = true;
                        error_log('$activeSub->cancel_at_period_end'.$activeSub->cancel_at_period_end);
                    } else {
                        wp_send_json_error([
                            'message' => 'This plan is already actual. No action needed',
                            'plan' => $plan,
                            'subscription' => $activeSub,
                        ]);
                    }
                }else{$needsUpdate = true;}
            }
            if($needsUpdate){
                CheckoutHelper::updateUserProfile($userId, $data);
                $result = $this->updateSubscription($stripe, $activeSub, $plan['stripe_price_id']);
                error_log('Till here works - result');
                $subscription = $result['subscription'];
                $clientSecret = $result['client_secret'];
                error_log('Till here works - end');
            } else {
                $subscription = $this->createSubscription($stripe, $customer->id, $plan['stripe_price_id'], $data['payment_method_id'], $signupToken);
                $clientSecret = $subscription->latest_invoice->confirmation_secret->client_secret ?? null;
            }

            $response = [
                'signup_token' => $signupToken,
                'redirect_url'=>home_url('processing'),
                'userId' => $userId,
                'customer' => $customer,
                'subscription' => $subscription,
                'status' => 'payment_started',
                'client_secret' => $clientSecret
            ];

            wp_send_json_success($response);

        } catch (\Throwable $e) {
            error_log('CHECKOUT ERROR: ' . $e->getMessage());
            wp_send_json_error([
                'message' => $e->getMessage(),
            ]);
        }
    }
    private function createSubscription(StripeClient $stripe, string $customerId, string $priceId, string $paymentMethodId, string $signupToken) {

        try{
            return $stripe->subscriptions->create([
                'customer' => $customerId,
                'items' => [['price' => $priceId]],
                'default_payment_method' => $paymentMethodId,
                'payment_behavior' => 'default_incomplete',
                'payment_settings' => [
                    'payment_method_types' => ['card'],
                    'save_default_payment_method' => 'on_subscription',
                ],

                //'proration_behavior' => 'create_prorations',
                'expand' => ['latest_invoice.confirmation_secret'],
                //'expand' => ['pending_setup_intent'],
                'metadata' => [
                    'signup_token' => $signupToken,
                    'price_id' => $priceId
                ],
            ]);
        }catch (\Exception $e){
            error_log('CHECKOUT ERROR: ' . $e->getMessage());
        }
    }

    /**
     * @throws ApiErrorException
     */
    private function updateSubscription(StripeClient $stripe, object $subscription, string $newPriceId): array {

        $itemId = $subscription->items->data[0]->id;
        $subscription = $stripe->subscriptions->update(
            $subscription->id,
            [
                'items' => [[
                    'id' => $itemId,
                    'price' => $newPriceId,
                ]],
                'proration_behavior' => 'always_invoice',
                'payment_behavior' => 'default_incomplete',
                'cancel_at_period_end' => false,
            ]
        );

        $clientSecret = null;

        $invoiceId = is_string($subscription->latest_invoice) ? $subscription->latest_invoice : $subscription->latest_invoice?->id;
        if ($invoiceId) {
            $invoice = $stripe->invoices->retrieve($invoiceId,
                ['expand' => ['confirmation_secret']]
            );
            $clientSecret = $invoice->confirmation_secret?->client_secret;
        }
        return [
            'subscription' => $subscription,
            'client_secret' => $clientSecret,
        ];
    }
    private function getOrCreateCustomer(StripeClient $stripe, array $data, int $userId): object{
        $customers = $stripe->customers->all([
            'email' => $data['email'],
            'limit' => 1
        ]);

        if (!empty($customers->data)) {
            return $stripe->customers->update($customers->data[0]->id, [
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
            ]);
        }

        return $stripe->customers->create([
            'email' => $data['email'],
            'name' => $data['name'],
            'phone' => $data['phone'],
            'metadata' => [
                'wp_user_id' => $userId
            ]
        ]);
    }
    /**
     * @throws ApiErrorException
     */
    private function attachPaymentMethod(StripeClient $stripe, string $pm, string $customerId): void
    {
        try {
            $stripe->paymentMethods->attach($pm, [
                'customer' => $customerId
            ]);
        } catch (ApiErrorException $e) {
            if ($e->getStripeCode() !== 'resource_already_exists') {
                throw $e;
            }
        }

        $stripe->customers->update($customerId, [
            'invoice_settings' => [
                'default_payment_method' => $pm
            ]
        ]);
    }
    private function getActiveSubscription(StripeClient $stripe, string $customerId): ?object
    {
        try{
            $subs = $stripe->subscriptions->all([
                'customer' => $customerId,
                'status' => 'all',
                'limit' => 10
            ]);
            return array_find($subs->data, fn($sub) => in_array($sub->status, [
                'active',
                'trialing',
                'past_due',
                'incomplete',
                //'canceled'
            ], true));
        }catch (\Exception $e){
            return null;
        }
    }

}