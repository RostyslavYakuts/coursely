<?php

namespace coursely\App\Core\Handlers;

use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class AjaxCheckout
{
    private const SIGNUP_TRANSIENT_PREFIX =
        'coursely_signup_';

    public function __construct()
    {
        add_action(
            'wp_ajax_nopriv_checkout_action',
            [$this, 'handle_stripe_checkout']
        );

        add_action(
            'wp_ajax_checkout_action',
            [$this, 'handle_stripe_checkout']
        );
    }

    public function handle_stripe_checkout(): void
    {
        $signupToken = null;

        try {

            $this->verifyNonce();

            $data =
                $this->getRequestData();

            $this->validateRequest(
                $data
            );

            $signupToken =
                $this->createSignupToken(
                    $data
                );

            $stripe =
                $this->getStripeClient();

            $priceId =
                $this->getStripePriceId(
                    $data['plan_id']
                );

            $customer =
                $this->createOrGetCustomer(
                    $stripe,
                    $data,
                    $signupToken
                );

            $subscription =
                $this->createSubscription(
                    $stripe,
                    $customer->id,
                    $priceId
                );

            $paymentIntent =
                $subscription
                    ->latest_invoice
                    ->payment_intent;

            // 3D Secure
            if (
                $paymentIntent &&
                $paymentIntent->status ===
                'requires_action'
            ) {

                wp_send_json_success([
                    'requires_action' => true,
                    'client_secret' =>
                        $paymentIntent
                            ->client_secret,
                ]);

                return;
            }

            // immediate success
            if (in_array($subscription->status, ['active', 'trialing'], true)) {

                wp_send_json_success([
                    'message' => 'Subscription created.',
                    'redirect_url' => home_url('/checkout-success/'),
                ]);

                return;
            }

            // card declined
            if ($paymentIntent && $paymentIntent->status === 'requires_payment_method') {

                delete_transient(self::SIGNUP_TRANSIENT_PREFIX . $signupToken);
                wp_send_json_error(['message' => $paymentIntent->last_payment_error?->message ?? 'Card declined.']);

                return;
            }

            delete_transient(self::SIGNUP_TRANSIENT_PREFIX . $signupToken);

            wp_send_json_error(['message' => 'Unexpected payment status.']);

        } catch (\Throwable $e) {

            if ($signupToken) {
                delete_transient(self::SIGNUP_TRANSIENT_PREFIX . $signupToken);
            }

            error_log('Stripe Checkout Error: ' . $e->getMessage());

            wp_send_json_error(['message' => 'Checkout failed. Please try again.']);
        }
    }

    private function verifyNonce(): void
    {
        $nonce = $_POST['nonce'] ?? '';

        if (!wp_verify_nonce($nonce, 'checkout_action')) {

            wp_send_json_error(['message' => 'Security check failed.']);

            return;
        }
    }

    private function getRequestData(): array
    {
        return [
            'payment_method_id' => sanitize_text_field($_POST['payment_method_id'] ?? ''),
            'plan_id' => sanitize_text_field($_POST['plan_id'] ?? ''),
            'email' => sanitize_email($_POST['subscriber_email'] ?? ''),
            'name' => sanitize_text_field($_POST['subscriber_name'] ?? ''),
            'phone' => sanitize_text_field($_POST['subscriber_phone'] ?? ''),
            'password' => $_POST['subscriber_password'] ?? '',
            'address' => [
                'line1' => sanitize_text_field($_POST['subscriber_street_address'] ?? ''),
                'line2' => sanitize_text_field($_POST['subscriber_street_address_2'] ?? ''),
                'city' => sanitize_text_field($_POST['subscriber_city'] ?? ''),
                'state' => sanitize_text_field($_POST['subscriber_state'] ?? ''),
                'postal_code' => sanitize_text_field($_POST['subscriber_zip'] ?? ''),
                'country' => sanitize_text_field($_POST['subscriber_country'] ?? ''),
            ],
        ];
    }

    private function validateRequest(array $data): void {

        $required = [
            'payment_method_id',
            'plan_id',
            'email',
            'name',
            'phone',
            'password',
        ];

        foreach ($required as $field) {

            if (empty($data[$field])) {
                wp_send_json_error(['message' => 'Required field missing.']);
                return;
            }
        }

        if (!is_email($data['email'])) {
            wp_send_json_error(['message' => 'Invalid email.']);
            return;
        }
        if (email_exists($data['email'])) {
            wp_send_json_error(['message' => 'Email already exists.']);
            return;
        }

        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,}$/', $data['password'])) {
            wp_send_json_error(['message' => 'Password too weak.']);
            return;
        }

        if (!array_key_exists($data['plan_id'], $this->get_stripe_prices())) {
            wp_send_json_error(['message' => 'Invalid plan.']);
            return;
        }
    }

    private function getStripeClient():
    StripeClient {

        $secretKey = get_field('stripe_secret_key', 'options');

        if (empty($secretKey)) {
            throw new \Exception('Stripe key missing.');
        }
        return new StripeClient($secretKey);
    }

    private function getStripePriceId(string $planId): string {
        return $this->get_stripe_prices()[$planId];
    }

    /**
     * @throws ApiErrorException
     */
    private function createOrGetCustomer(StripeClient $stripe, array $data, string $signupToken): object {

        $customers = $stripe->customers->all([
                    'email' => $data['email'],
                    'limit' => 1
                ]);

        // existing customer
        if (!empty($customers->data)) {
            $customer = $customers->data[0];
        } else {
            $customer = $stripe->customers->create([

                        'email' => $data['email'],
                        'name' => $data['name'],
                        'phone' => $data['phone'],
                        'address' => $data['address'],
                        'metadata' => [
                            'signup_token' => $signupToken,
                            'plan_id' => $data['plan_id'],
                            'site_user_email' => $data['email'],
                        ]
                    ]);
        }

        // attach card
        $stripe->paymentMethods->attach($data['payment_method_id'], ['customer' => $customer->id]);

        // set default card
        $stripe->customers->update($customer->id,
                [
                    'invoice_settings' => ['default_payment_method' => $data['payment_method_id']]
                ]
            );

        return $customer;
    }

    /**
     * @throws ApiErrorException
     */
    private function createSubscription(StripeClient $stripe, string $customerId, string $priceId): object {

        return $stripe->subscriptions->create([
                    'customer' => $customerId,
                    'items' => [['price' => $priceId]],
                    'payment_behavior' => 'default_incomplete',
                    'expand' => ['latest_invoice.payment_intent'],
                ]);
    }

    private function createSignupToken(array $data): string {
        $token = wp_generate_uuid4();
        set_transient(self::SIGNUP_TRANSIENT_PREFIX . $token, $data, HOUR_IN_SECONDS);
        return $token;
    }

    public function get_stripe_prices(): array {
        $plans = get_field('plans', 'options');
        $arr = [];
        foreach($plans as $plan) {
            $arr[$plan['get_parameter_plan_key']] = $plan['stripe_price_id'];
        }
        return $arr;
    }
}