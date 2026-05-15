<?php

namespace coursely\App\Core\Handlers;

use coursely\App\Core\Helpers\NonceChecker;

class AjaxCheckoutStatus
{
    public function __construct()
    {
        add_action('wp_ajax_check_checkout_status', [$this, 'handle']);
        add_action('wp_ajax_nopriv_check_checkout_status', [$this, 'handle']);
    }
    public function handle(): void
    {
        NonceChecker::check('check_checkout_status');

        try {
            $token = sanitize_text_field(wp_unslash($_POST['token']) ?? '');
            if (!$token) {
                wp_send_json_error([
                    'post'=>$_POST,
                    'message' => 'Missing token'
                ]);
            }

            $signupData = get_transient('coursely_signup_' . $token);

            if (!$signupData) {
                wp_send_json_success([
                    'signup_data'=>$signupData,
                    'ready' => false,
                ]);
            }

            $userId = email_exists($signupData['email']);

            // webhook did not create the user
            if (!$userId) {
                wp_send_json_success(['ready' => false]);
            }

            // auto login
            wp_set_current_user($userId);
            wp_set_auth_cookie($userId, true);
            if ($token) {
                delete_transient('coursely_signup_' . $token);
            }
            wp_send_json_success([
                'ready' => true,
                'redirect_url' => home_url('/account/')
            ]);

        } catch (\Throwable $e) {

            wp_send_json_error([
                'message' => $e->getMessage()
            ]);
        }
    }
}