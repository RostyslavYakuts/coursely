<?php
namespace coursely\App\Core\Handlers;

class AjaxAuthHandler
{
    public function __construct(){
        add_action('wp_ajax_nopriv_login_form_action', [$this, 'login_form_action']);
        add_action('wp_ajax_login_form_action', [$this, 'login_form_action']);
    }

    public function login_form_action(): void
    {
        if ( !isset($_POST['nonce']) || !wp_verify_nonce(wp_unslash($_POST['nonce']), 'login_form_action') ) {
            wp_send_json_error([
                'message' => __('Security validation failed.'),
                'post'=>$_POST
            ],403);
        }
        $token = isset($_POST['recaptcha_token']) ? sanitize_text_field(wp_unslash($_POST['recaptcha_token'])) : '';
        // Validate reCAPTCHA (v3)
        $secret_key = get_field('recaptcha_secret_key', 'option');
        $use_recaptcha = get_field('use_recaptcha', 'option');
        $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
            'body' => [
                'secret' => $secret_key,
                'response' => $token,
                'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
                'timeout' => 5
            ],
        ]);

        if (is_wp_error($response) && $use_recaptcha) {
            wp_send_json_error([
                'message' => 'reCAPTCHA request failed'
            ]);
        }



        if (is_user_logged_in()) {
            wp_send_json_success();
        }

        $email = sanitize_email(
            wp_unslash($_POST['email'] ?? '')
        );

        $password = (string) ($_POST['password'] ?? '');

        $errors = [];

        if (!$email || !is_email($email)) {
            $errors['login_user_email'] =
                __('Valid email required');
        }

        if (empty($password)) {
            $errors['login_user_password'] =
                __('Password required');
        }

        if ($errors) {
            wp_send_json_error([
                'field_errors'=>$errors
            ],422);
        }

        $user = get_user_by('email',$email);

        // prevent username/email ambiguity issues
        if (!$user) {
            wp_send_json_error([
                'message'=>__('Invalid credentials.')
            ],401);
        }

        $creds = [
            'user_login'    => $user->user_login,
            'user_password' => $password,
            'remember'      => true
        ];

        $signed_user = wp_signon(
            $creds,
            is_ssl()
        );

        if (is_wp_error($signed_user)) {

            wp_send_json_error([
                'message'=>__('Invalid credentials.')
            ],401);
        }

        // extra hardening
        wp_set_current_user($signed_user->ID);
        wp_set_auth_cookie(
            $signed_user->ID,
            true,
            is_ssl()
        );

        wp_send_json_success([
            'message'=>'Authenticated'
        ]);
    }


}