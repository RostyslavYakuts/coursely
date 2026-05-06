<?php

namespace coursely\App\Models;

class AboutPageModel implements ModelInterface
{
    public \WP_Post $post;
    public function __construct($post){
        $this->post = $post;
    }

    public function get_post_data(): array
    {
        $id = $this->post->ID;
        $front_page_id = get_option('page_on_front');
        $content = apply_filters('the_content', get_the_content());

        return [
            'id'=>$id,
            'title'=>get_the_title($id),
            'thumbnail' => get_the_post_thumbnail(),
            'content' => $content,
            'h1'=>get_field('h1', $id) ?? '',
            'description'=>get_field('description', $id) ?? '',
            'who_we_are'=>get_field('who_we_are', $id) ?? [],

            'why_section_title'=>get_field('why_section_title',$front_page_id ) ?? '',
            'why_section_image'=>get_field('why_section_image',$front_page_id ) ?? [],
            'why_section_cta'=>get_field('why_section_cta',$front_page_id ) ?? '',
            'why_section_cta_link'=>get_field('why_section_cta_link',$front_page_id ) ?? '',
            'why_section_arguments'=>get_field('why_section_arguments',$front_page_id ) ?? [],

            'testimonials_title' => get_field('testimonials_title', $front_page_id ) ?? '',
            'testimonials_description' => get_field('testimonials_description', $front_page_id ) ?? '',
            'testimonials_slider' => get_field('testimonials_slider', $front_page_id ) ?? [],
        ];
    }

}