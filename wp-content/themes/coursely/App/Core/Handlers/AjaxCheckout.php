<?php

namespace coursely\App\Core\Handlers;

use coursely\App\Core\Helpers\NonceChecker;
use coursely\App\Core\Helpers\RecaptchaChecker;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;

class AjaxCheckout
{
    private const SIGNUP_TRANSIENT_PREFIX = 'coursely_signup_';

    public function __construct()
    {
        add_action('wp_ajax_nopriv_checkout_action', [$this, 'handle_stripe_checkout']);
        add_action('wp_ajax_checkout_action', [$this, 'handle_stripe_checkout']);
    }


    public function handle_stripe_checkout(): void
    {
        $signupToken = null;

        try {
            NonceChecker::check('checkout_action');
            RecaptchaChecker::check();
            $data = $this->getRequestData();
            $this->validateRequest($data);

            $stripe = $this->getStripeClient();
            $priceId = $this->getStripePriceId($data['plan_id']);
            $signupToken = $this->createSignupToken($data);

            $customer = $this->createCustomer($stripe, $data, $signupToken);
            $this->attachPaymentMethod($stripe, $data['payment_method_id'], $customer->id);

            // Створюємо підписку
            // Якщо Auto-advance увімкнено в Dashboard, Stripe одразу створить PaymentIntent
            $subscription = $this->createSubscription($stripe, $customer->id, $priceId, $data['payment_method_id']);

            // Отримуємо інвойс та пеймент інентент з відповіді підписки
            $invoice = $subscription->latest_invoice;
            $paymentIntent = $invoice->payment_intent;

            // 1. Якщо потрібна 3D Secure
            if ($paymentIntent && $paymentIntent->status === 'requires_action') {
                wp_send_json_success([
                    'requires_action' => true,
                    'client_secret' => $paymentIntent->client_secret,
                    'redirect_url'    => home_url('/checkout-success/'),
                ]);
            }

            // 2. Якщо платіж успішний (наприклад, тестова карта 4242)
            if ($paymentIntent && in_array($paymentIntent->status, ['succeeded', 'processing'], true)) {
                wp_send_json_success([
                    'message' => 'Payment successful.',
                    'redirect_url' => home_url('/checkout-success/')
                ]);
            }

            // 3. Якщо підписка активна (наприклад, пробний період)
            if (in_array($subscription->status, ['active', 'trialing'], true)) {
                wp_send_json_success([
                    'message' => 'Subscription created.',
                    'redirect_url' => home_url('/checkout-success/'),
                ]);
            }

            // 4. Якщо картку відхилено (hard decline)
            if ($paymentIntent && $paymentIntent->status === 'requires_payment_method') {
                delete_transient(self::SIGNUP_TRANSIENT_PREFIX . $signupToken);
                $errorMsg = 'Card declined.';
                if ($paymentIntent->last_payment_error) {
                    $errorMsg = $paymentIntent->last_payment_error->message ?? $errorMsg;
                }
                wp_send_json_error(['message' => $errorMsg]);
            }

            // Непередбачуваний статус
            delete_transient(self::SIGNUP_TRANSIENT_PREFIX . $signupToken);
            error_log('Unexpected status');
            wp_send_json_error([
                'message' => 'Unexpected payment status.',
                'subscription' => $subscription,
                'payment_intent' => $paymentIntent,
                'post'=>$_POST,
                'price' => $priceId,
                'customer' => $customer,
                'stripe' => $stripe,
            ]);


        } catch (\Throwable $e) {
            if ($signupToken) {
                delete_transient(self::SIGNUP_TRANSIENT_PREFIX . $signupToken);
            }
            error_log('STRIPE CHECKOUT ERROR: ' . $e->getMessage());
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }
    private function createCustomer(StripeClient $stripe, array $data, string $signupToken): object {

        return $stripe->customers->create([
            'email'   => $data['email'],
            'name'    => $data['name'],
            'phone'   => $data['phone'],
            'address' => [
                'line1'       => $data['address']['line1'] ?? null,
                'line2'       => $data['address']['line2'] ?? null,
                'city'        => $data['address']['city'] ?? null,
                'state'       => $data['address']['state'] ?? null,
                'postal_code' => $data['address']['postal_code'] ?? null,
                'country'     => $data['address']['country'] ?? null,
            ],
            'metadata' => [
                'signup_token'    => $signupToken,
                'plan_id'         => $data['plan_id'],
                'site_user_email' => $data['email'],
            ]
        ]);
    }
    private function createSubscription(StripeClient $stripe, string $customerId, string $priceId, string $paymentMethodId): object {

        return $stripe->subscriptions->create([
            'customer'               => $customerId,
            'items'                  => [['price' => $priceId]],
            'default_payment_method' => $paymentMethodId,
            'payment_behavior'       => 'default_incomplete',
            'expand'                 => ['latest_invoice.payment_intent'],
        ]);
    }
    private function attachPaymentMethod(StripeClient $stripe, string $paymentMethodId, string $customerId): void
    {
        try {
            $stripe->paymentMethods->attach(
                $paymentMethodId,
                ['customer' => $customerId]
            );

            // Optional: Set as default for future invoices
            $stripe->customers->update(
                $customerId,
                [
                    'invoice_settings' => [
                        'default_payment_method' => $paymentMethodId,
                    ],
                ]
            );
        } catch (ApiErrorException $e) {
            error_log('Stripe Attach Error: ' . $e->getMessage());
            throw $e;
        }
    }






    private function getStripeClient(): StripeClient {

        $secretKey = get_field('stripe_secret_key', 'options');
        if (empty($secretKey)) {
            wp_send_json_error(['message' => 'Stripe key missing.']);
        }
        return new StripeClient($secretKey);
    }
    private function createSignupToken(array $data): string {
        $token = wp_generate_uuid4();
        set_transient(self::SIGNUP_TRANSIENT_PREFIX . $token, $data, HOUR_IN_SECONDS);
        return $token;
    }
    private function getStripePriceId(string $planId): string {
        return $this->get_stripe_prices()[$planId];
    }
    public function get_stripe_prices(): array {
        $plans = get_field('plans', 'options') ?? [];
        $arr = [];
        if(!$plans){
            return $arr;
        }
        foreach($plans as $plan) {

            if (empty($plan['get_parameter_plan_key']) || empty($plan['stripe_price_id'])) {
                continue;
            }
            $arr[$plan['get_parameter_plan_key']] = $plan['stripe_price_id'];
        }
        return $arr;
    }
    private function getRequestData(): array
    {
        return [
            'payment_method_id' => sanitize_text_field(wp_unslash($_POST['payment_method_id'] ?? '')),
            'plan_id' => sanitize_text_field(wp_unslash($_POST['plan_id'] ?? '')),
            'email' => sanitize_email(wp_unslash($_POST['subscriber_email'] ?? '')),
            'name' => sanitize_text_field(wp_unslash($_POST['subscriber_name'] ?? '')),
            'phone' => sanitize_text_field(wp_unslash($_POST['subscriber_phone'] ?? '')),
            'password' => wp_unslash($_POST['subscriber_password'] ?? ''),
            'address' => [
                'line1' => sanitize_text_field(wp_unslash($_POST['subscriber_street_address'] ?? '')),
                'line2' => sanitize_text_field(wp_unslash($_POST['subscriber_street_address_2'] ?? '')),
                'city' => sanitize_text_field(wp_unslash($_POST['subscriber_city'] ?? '')),
                'state' => sanitize_text_field(wp_unslash($_POST['subscriber_state'] ?? '')),
                'postal_code' => sanitize_text_field(wp_unslash($_POST['subscriber_zip'] ?? '')),
                'country' => sanitize_text_field(wp_unslash($_POST['subscriber_country'] ?? '')),
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
            }
        }

        if (!is_email($data['email'])) {
            wp_send_json_error(['message' => 'Invalid email.']);
        }
        if (email_exists($data['email'])) {
            wp_send_json_error(['message' => 'Email already exists.']);
        }
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,}$/', $data['password'])) {
            wp_send_json_error(['message' => 'Password too weak.']);
        }
        if (!array_key_exists($data['plan_id'], $this->get_stripe_prices())) {
            wp_send_json_error(['message' => 'Invalid plan.']);
        }
    }


}