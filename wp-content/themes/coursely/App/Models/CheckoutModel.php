<?php

namespace coursely\App\Models;

use coursely\App\Core\Helpers\Countries;

class CheckoutModel implements ModelInterface
{
    public \WP_Post$page;

    public function __construct($page){
        $this->page = $page;
    }

    public function get_post_data(): array
    {
        $id = $this->page->ID;

        $countries = Countries::getCountries();
        $user_data = [];
        $is_user_logged_in = is_user_logged_in();
        if($is_user_logged_in){
            $user = wp_get_current_user();
            $user_data = [
                'ID' => $user->ID,
                'user_firstname' => $user->user_firstname,
                'user_email' => $user->user_email,
                'user_phone' => get_field('phone', 'user_'.$user->ID),
                'user_country' => get_field('country', 'user_'.$user->ID),
                'user_country_code' => get_field('country_code', 'user_'.$user->ID),
                'user_postal_code' => get_field('postal_code', 'user_'.$user->ID),
                'user_state' => get_field('state', 'user_'.$user->ID),
                'user_city' => get_field('city', 'user_'.$user->ID),
                'user_company' => get_field('company', 'user_'.$user->ID),
                'user_address_line_1' => get_field('address_line_1', 'user_'.$user->ID),
                'user_address_line_2' => get_field('address_line_2', 'user_'.$user->ID),
                'user_cardholder_name' => get_field('cardholder_name', 'user_'.$user->ID),
            ];
        }

        return [
            'id' => $id,
            'title' => get_the_title(),
            'content' => apply_filters('the_content', get_the_content()),
            'background_image_url'=>get_the_post_thumbnail_url($id,'full'),
            'h1'=>get_field('h1',$id),
            'plan'=>$this->get_selected_plan(),
            'plans_features_text'=>get_field('plans_features_text', 'options') ?? 'Features included:',
            'countries'=>$countries,
            'user_data'=>$user_data,
            'is_user_logged_in'=>$is_user_logged_in,
        ];

    }

    private function get_selected_plan():array
    {
        $plan_key = $_GET['price_id'] ?? null;

        $plans = get_field('plans', 'options') ?? [];

        if ($plan_key) {
            foreach ($plans as $plan) {
                if (($plan['get_parameter_plan_key'] ?? null) === $plan_key) {
                    return $plan;
                }
            }
        }

        foreach ($plans as $plan) {
            if ($plan['is_popular']) {
                return $plan;
            }
        }

        return $plans[0] ?? [];
    }
}