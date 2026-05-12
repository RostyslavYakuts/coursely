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

        return [
            'id' => $id,
            'title' => get_the_title(),
            'content' => apply_filters('the_content', get_the_content()),
            'background_image_url'=>get_the_post_thumbnail_url($id,'full'),
            'h1'=>get_field('h1',$id),
            'plan'=>$this->get_selected_plan(),
            'plans_features_text'=>get_field('plans_features_text', 'options') ?? 'Features included:',
            'countries'=>$countries,
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