<?php

namespace coursely\App\Models;

use coursely\App\Models\CustomEntityModels;
use coursely\App\Models\ModelInterface;

class PricingPageModel implements ModelInterface
{
    public \WP_Post $post;
    public function __construct($post){
        $this->post = $post;
    }

    public function get_post_data(): array
    {
        $id = $this->post->ID;
        $content = apply_filters('the_content', get_the_content());

        return [
            'id'=>$id,
            'title'=>get_the_title($id),
            'thumbnail' => get_the_post_thumbnail(),
            'content' => $content,
            'h1'=>get_field('h1', $id) ?? '',
            'description'=>get_field('description', $id) ?? '',
            'plans_cta'=>get_field('plans_cta', 'options') ?? 'Get started',
            'plans_features_text'=>get_field('plans_features_text', 'options') ?? 'Features included:',
            'plans'=>get_field('plans', 'options') ?? [],
            'faq_title'=>get_field('faq_title', $id) ?? '',
            'faq_description'=>get_field('faq_description', $id) ?? '',
            'faq'=>get_field('faq', $id) ?? [],
        ];
    }

}