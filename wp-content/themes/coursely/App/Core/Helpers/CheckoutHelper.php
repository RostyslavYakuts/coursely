<?php

namespace coursely\App\Core\Helpers;

use Stripe\StripeClient;

class CheckoutHelper
{
    private const string TRANSIENT_PREFIX = 'coursely_signup_';

    public static function getStripeClient(): StripeClient
    {
        $key = get_field('stripe_secret_key', 'options');

        if (!$key) {
            throw new \Exception('Missing Stripe key');
        }

        return new StripeClient($key);
    }
    public static function createSignupToken(array $data): string
    {
        $token = wp_generate_uuid4();

        set_transient(self::TRANSIENT_PREFIX . $token, $data, HOUR_IN_SECONDS);

        return $token;
    }
    public static function getRequestData(): array
    {
        return [
            'payment_method_id' => sanitize_text_field(wp_unslash($_POST['payment_method_id'] ?? '')),
            'plan_id' => sanitize_text_field(wp_unslash($_POST['plan_id'] ?? '')),
            'email' => sanitize_email(wp_unslash($_POST['subscriber_email'] ?? '')),
            'name' => sanitize_text_field(wp_unslash($_POST['subscriber_name'] ?? '')),
            'cardholder_name' => sanitize_text_field(wp_unslash($_POST['subscriber_cardholder_name'] ?? '')),
            'phone' => sanitize_text_field(wp_unslash($_POST['subscriber_phone'] ?? '')),
            'company' => sanitize_text_field(wp_unslash($_POST['subscriber_company_name'] ?? '')),
            'password' => wp_unslash($_POST['subscriber_password'] ?? ''),
            'address' => [
                'line1' => sanitize_text_field(wp_unslash($_POST['subscriber_street_address'] ?? '')),
                'line2' => sanitize_text_field(wp_unslash($_POST['subscriber_street_address_2'] ?? '')),
                'city' => sanitize_text_field(wp_unslash($_POST['subscriber_city'] ?? '')),
                'state' => sanitize_text_field(wp_unslash($_POST['subscriber_state'] ?? '')),
                'postal_code' => sanitize_text_field(wp_unslash($_POST['subscriber_zip'] ?? '')),
                'country' => sanitize_text_field(wp_unslash($_POST['subscriber_country'] ?? '')),
                'country_code' => sanitize_text_field(wp_unslash($_POST['subscriber_country_code'] ?? '')),
            ],
        ];
    }

    /**
     * @throws \Exception
     */
    public static function validateRequest(array $data, int $userId = 0): void
    {
        $required = ['payment_method_id', 'plan_id', 'email', 'name', 'phone'];
        foreach ($required as $field) {
            if (empty($data[$field])) wp_send_json_error(['message' => "Missing: $field"]);
        }

        if (!is_email($data['email'])) wp_send_json_error(['message' => 'Invalid email.']);

        if ($userId === 0) {
            if (email_exists($data['email'])) wp_send_json_error(['message' => 'Email exists. Please login.']);
            if (empty($data['password'])) wp_send_json_error(['message' => 'Password required.']);
            if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,}$/', $data['password'])) {
                wp_send_json_error(['message' => 'Password too weak.']);
            }
        }
        $plan = self::getPlanByPlanId($data['plan_id']);
        if (empty($plan)) {
            wp_send_json_error([
                'message' => 'Invalid plan.'
            ]);
        }
    }

    /**
     * @throws \Exception
     */
    public static function getPlanByPlanId(string $planId): array
    {
        $plans = get_field('plans', 'options');
        foreach ($plans as $plan) {
            if ($plan['get_parameter_plan_key'] === $planId) {
                return $plan;
            }
        }
        throw new \Exception('Invalid plan');
    }

    /**
     * @throws \Exception
     */
    public static function getPlanByPlanStripePriceId(string $stripe_price_id): array
    {
        $plans = get_field('plans', 'options');
        foreach ($plans as $plan) {
            if ($plan['stripe_price_id'] === $stripe_price_id) {
                return $plan;
            }
        }
        throw new \Exception('Invalid plan');
    }

    public static function isSamePlan(object $subscription, string $priceId): bool
    {
        return $subscription->items->data[0]->price->id === $priceId;
    }
    public static function updateUserProfile(int $userId, array $data): void
    {
        $userData = [
            'ID' => $userId,
            'display_name' => $data['name'],
            'first_name'   => $data['name'],
            'user_email'   => $data['email'],
        ];
        wp_update_user($userData);
        update_field('phone', $data['phone'] ?? '', 'user_' . $userId);
        update_field('cardholder_name', $data['name'] ?? '', 'user_' . $userId);
        update_field('company', $data['company'], 'user_' . $userId);
        if (isset($data['address']) && is_array($data['address'])) {
            update_field('address_line_1', $data['address']['line1'] ?? '', 'user_' . $userId);
            update_field('address_line_2', $data['address']['line2'] ?? '', 'user_' . $userId);
            update_field('city', $data['address']['city'] ?? '', 'user_' . $userId);
            update_field('state', $data['address']['state'] ?? '', 'user_' . $userId);
            update_field('postal_code', $data['address']['postal_code'] ?? '', 'user_' . $userId);
            update_field('country', $data['address']['country'] ?? '', 'user_' . $userId);
            update_field('country_code', $data['address']['country_code'] ?? '', 'user_' . $userId);
        }
    }
}