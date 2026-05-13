<?php

namespace coursely\App\Core\Helpers;

class RecaptchaChecker
{
    public static function check(): void
    {

        $use_recaptcha = get_field('use_recaptcha', 'options');
        if (!$use_recaptcha) {
            return;
        }
        $token = isset($_POST['recaptcha_token']) ? sanitize_text_field(wp_unslash($_POST['recaptcha_token'])) : '';
        if (empty($token)) {
            wp_send_json_error([
                'message' => '<h3 class="text-[20px] lgx:text-[24px] font-bold">reCAPTCHA</h3> <span class="block mt-[12px]">Token is missing.</span>'
            ], 400); // HTTP 400 Bad Request
        }

        $secret_key = get_field('recaptcha_secret_key', 'options');

        $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
            'timeout' => 5,
            'body' => [
                'secret' => $secret_key,
                'response' => $token,
                'remoteip' => UserIpDetector::detect(),

            ],
        ]);
        if (is_wp_error($response)) {
            wp_send_json_error([
                'message' => '<h3 class="text-[20px] lgx:text-[24px] font-bold">reCAPTCHA</h3> <span class="block mt-[12px]">request failed.</span>'
            ]);
        }

        $result = json_decode(wp_remote_retrieve_body($response), true);
        $success = ! empty($result['success']);
        $score   = isset($result['score']) ? (float) $result['score'] : 0.0;

        if ( ! $success || $score < 0.7 ) {
            wp_send_json_error([
                'message' => '<h3 class="text-[20px] lgx:text-[24px] font-bold">reCAPTCHA</h3> <span class="block mt-[12px]">Verification failed. Bot detected.</span>'
            ], 403);
        }
    }
}