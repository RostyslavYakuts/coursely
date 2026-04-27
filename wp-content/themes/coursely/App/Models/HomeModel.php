<?php

namespace coursely\App\Models;

class HomeModel implements ModelInterface
{
    public \WP_Post$page;

    public function __construct($page){
        $this->page = $page;
    }

    public function get_post_data(): array
    {
        $id = $this->page->ID;
        $h1 = get_field('h1', $id) ?: '';

        return [
            'id' => $id,
            'h1'=> $h1,
            'trusted_by'=>get_field('trusted_by', $id) ?? '10k',
            'trusted_by_image'=>get_field('trusted_by_image', $id) ?? [],
            'thumbnail_url'=>get_the_post_thumbnail_url($id,'medium_large'),
            'description'=>get_field('description', $id)??'',
            'cta_text'=>get_field('cta_text',$id) ?? '',
            'cta_link'=>get_field('cta_link',$id) ?? '',
            'cta_2_text'=>get_field('cta_2_text',$id) ?? '',
            'cta_2_link'=>get_field('cta_2_link',$id) ?? '',

            'services_section_title'=>get_field('services_section_title',$id) ?? '',
            'services_section_description'=>get_field('services_section_description',$id) ?? '',
            'services'=>$this->get_services(),

            'cases_title'=>get_field('cases_title',$id) ?? '',
            'cases_description'=>get_field('cases_description',$id) ?? '',
            'cases'=>get_field('cases',$id) ?? [],

            'latest_plugin_title'=>get_field('latest_plugin_title',$id) ?? '',
            'latest_plugin_description'=>get_field('latest_plugin_description',$id) ?? '',
            'latest_plugin_link'=>get_field('latest_plugin_link',$id) ?? '',
            'latest_plugin_images'=>get_field('latest_plugin_images',$id) ?? [],

            'process_section_title'=>get_field('process_section_title',$id) ?? '',
            'process_section_description'=>get_field('process_section_description',$id) ?? '',
            'process'=>get_field('process',$id) ?? [],



            'statistic_section_title'=>get_field('statistic_section_title',$id) ?? '',
            'statistic_section_marks'=>get_field('statistic_section_marks',$id) ?? [],

            'banner_title'=>get_field('banner_title',$id) ?? '',
            'banner_description'=>get_field('banner_description',$id) ?? '',
            'banner_image'=>get_field('banner_image',$id) ?? [],
            'banner_cta_link'=>get_field('banner_cta_link',$id) ?? '',

            'testimonials_title' => get_field('testimonials_title', $id) ?? '',
            'testimonials_description' => get_field('testimonials_description', $id) ?? '',
            'testimonials_slider' => get_field('testimonials_slider', $id) ?? [],

            'brands_title' => get_field('brands_title', $id) ?? '',
            'brands_description' => get_field('brands_description', $id) ?? '',
            'brands' => get_field('brands', $id) ?? [],

            'title' => get_the_title(),
            'content' => apply_filters('the_content', get_the_content()),

        ];

    }

    private function get_services(): \WP_Query
    {
        $args = array(
            'posts_per_page' => -1,
            'order'          => 'DESC',
            'post_type'      => 'service',
            'post_status'    => 'publish',
        );
        return new \WP_Query( $args );
    }
}