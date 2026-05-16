<?php

namespace coursely\App\Core\Handlers;

use coursely\App\Core\Helpers\CheckoutHelper;
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

            // Case user already has this plan as active subscription
            if ($activeSub && CheckoutHelper::isSamePlan($activeSub, $plan['stripe_price_id'])) {
                if ($activeSub->status === 'active') {
                    wp_send_json_error(
                        [
                            'message' => 'This plan is already actual. No action needed',
                            'plan'=>$plan,
                            'active_subscription'=>$activeSub,
                            'customer'=>$customer,
                        ]);
                }
            }
            if ($activeSub) {
                $subscription = $this->updateSubscription($stripe, $activeSub, $plan['stripe_price_id'], $data['payment_method_id']);
                CheckoutHelper::updateUserProfile($userId, $data);
            } else {
                $subscription = $this->createSubscription($stripe, $customer->id, $plan['stripe_price_id'], $data['payment_method_id'], $signupToken);
            }

            $response = [
                'signup_token' => $signupToken,
                'redirect_url'=>home_url('processing'),
                'userId' => $userId,
                'customer' => $customer,
                'subscription' => $subscription,
                'status' => 'payment_started',
                'subscription_id' => $subscription->id,
                'invoice'=>$subscription->latest_invoice,
                'client_secret' => $subscription->latest_invoice->confirmation_secret->client_secret ?? null
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
                'metadata' => [
                    'signup_token' => $signupToken,
                    'price_id' => $priceId
                ],
            ]);
        }catch (\Exception $e){
            error_log('CHECKOUT ERROR: ' . $e->getMessage());
        }

    }
    private function updateSubscription(StripeClient $stripe, object $subscription, string $newPriceId, string $paymentMethodId) {

        $itemId = $subscription->items->data[0]->id;
        $params =[
            'items' => [[
                'id' => $itemId,
                'price' => $newPriceId
            ]],
            'default_payment_method' => $paymentMethodId,
            'proration_behavior' => 'always_invoice',
            'payment_behavior' => 'pending_if_incomplete',
            'cancel_at_period_end' => false, // IMPORTANT: If the user previously canceled, this reactivates the subscription
            'expand' => ['latest_invoice.confirmation_secret'],
        ];
        try{
            return $stripe->subscriptions->update($subscription->id, $params);
        }catch (\Exception $e){
            error_log('UPDATE ERROR: ' . $e->getMessage());
        }
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
                'incomplete'
            ], true));
        }catch (\Exception $e){
            return null;
        }
    }

}