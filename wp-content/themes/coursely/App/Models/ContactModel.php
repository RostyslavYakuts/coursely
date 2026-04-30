<?php

namespace coursely\App\Models;

use coursely\App\Models\ModelInterface;

class ContactModel implements ModelInterface
{
    public \WP_Post$page;

    public function __construct($page){
        $this->page = $page;
    }

    public function get_post_data(): array
    {
        $id = $this->page->ID;
        return [
            'id' => $id,
            'title' => get_the_title(),
            'content' => apply_filters('the_content', get_the_content()),
            'background_image_url'=>get_the_post_thumbnail_url($id,'full'),
            'h1'=>get_field('h1',$id),
            'description'=>get_field('description',$id),
            'faq_title'=>get_field('faq_title', $id) ?? '',
            'faq_description'=>get_field('faq_description', $id) ?? '',
            'faq'=>get_field('faq', $id) ?? [],
            'address'=>get_field('address', 'options') ?? '',
            'admin_email'=>get_field('admin_email', 'options') ?? '',
            'admin_phone'=>get_field('admin_phone', 'options') ?? '',
            'hours_of_operation'=>get_field('hours_of_operation', 'options') ?? '',
        ];

    }
}