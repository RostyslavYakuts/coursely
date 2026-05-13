<?php

namespace coursely\App\Core\Helpers;

class NonceChecker
{
    public static function check(string $action): void
    {
        $nonce = isset($_POST['nonce']) ? wp_unslash($_POST['nonce']) : '';
        if (!wp_verify_nonce($nonce, $action)) {
            wp_send_json_error([
                'message' => '<h3 class="text-[24px] font-bold">Warning!</h3> <span>Security check failed.</span>'
            ]);
        }
    }
}