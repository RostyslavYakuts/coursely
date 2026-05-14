<?php

namespace coursely\App\Models;

class ProcessingModel implements ModelInterface
{
    public \WP_Post$page;

    public function __construct($page){
        $this->page = $page;
    }

    public function get_post_data(): array
    {
        $id = $this->page->ID;
        //http://localhost:8080/processing/?token=66a187f3-e657-4655-9c69-d2fef3c71e32
        $token = sanitize_text_field(wp_unslash($_GET['token']) ?? '');

        if (!$token) {
            return [
                'id' => $id,
                'token' => null,
                'user' => null,
            ];
        }
        $signupData = get_transient('coursely_signup_' . $token);

        return [
            'id' => $id,
            'token' => $token,
            'user' => $signupData ? [
                'email' => $signupData['email'] ?? '',
                'name' => $signupData['name'] ?? '',
            ] : null,
        ];

    }
}