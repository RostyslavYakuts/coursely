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
        $course_categories = CustomEntityModels::get_custom_terms('course_category') ?? [];

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
            'statistic_section_marks'=>get_field('statistic_section_marks',$id) ?? [],

            'courses_section_title'=>get_field('courses_section_title',$id) ?? '',
            'courses_section_cta'=>get_field('courses_section_cta',$id) ?? '',
            'courses_section_cta_link'=>get_field('courses_section_cta_link',$id) ?? '',
            'course_categories' => $course_categories,
            'default_courses' => $this->get_featured_courses(),

            'why_section_title'=>get_field('why_section_title',$id) ?? '',
            'why_section_image'=>get_field('why_section_image',$id) ?? [],
            'why_section_cta'=>get_field('why_section_cta',$id) ?? '',
            'why_section_cta_link'=>get_field('why_section_cta_link',$id) ?? '',
            'why_section_arguments'=>get_field('why_section_arguments',$id) ?? [],

            'testimonials_title' => get_field('testimonials_title', $id) ?? '',
            'testimonials_description' => get_field('testimonials_description', $id) ?? '',
            'testimonials_slider' => get_field('testimonials_slider', $id) ?? [],

            'pricing_section_title' => get_field('pricing_section_title', $id) ?? '',
            'pricing_section_cta' => get_field('pricing_section_cta', $id) ?? '',
            'pricing_section_cta_link' => get_field('pricing_section_cta_link', $id) ?? '',
            'plans_cta'=>get_field('plans_cta', 'options') ?? 'Get started',
            'plans_features_text'=>get_field('plans_features_text', 'options') ?? 'Features included:',
            'plans'=>get_field('plans', 'options') ?? [],

            'faq_title' => get_field('faq_title', $id) ?? '',
            'faq_description' => get_field('faq_description', $id) ?? '',
            'faq' => get_field('faq', $id) ?? [],

            'title' => get_the_title(),
            'content' => apply_filters('the_content', get_the_content()),

        ];

    }

    private function get_featured_courses(): array
    {
        $query = new \WP_Query([
            'post_type'      => 'course',
            'posts_per_page' => 3,
            'meta_key'       => 'rating',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC'
        ]);

        if (!$query->have_posts()) {
            return [];
        }

        $courses = [];

        foreach ($query->posts as $post) {

            $terms = get_the_terms(
                $post->ID,
                'course_category'
            );

            $parent_category = '';

            if ($terms && !is_wp_error($terms)) {

                foreach ($terms as $term) {

                    // parent category
                    if ($term->parent) {

                        $parent = get_term($term->parent);

                        if ($parent && !is_wp_error($parent)) {
                            $parent_category = $parent->name;
                            break;
                        }
                    }

                    // fallback
                    if (!$term->parent) {
                        $parent_category = $term->name;
                    }
                }
            }

            $courses[] = [
                'id' => $post->ID,
                'title' => get_the_title($post->ID),
                'excerpt' => get_the_excerpt($post->ID),
                'link' => get_permalink($post->ID),
                'thumbnail' => get_the_post_thumbnail_url($post->ID, 'medium_large'),
                'rating' => get_field('rating', $post->ID),
                'duration' => get_field('duration', $post->ID),
                'lessons_count' => get_field('lessons_count', $post->ID),
                'category' => $parent_category
            ];
        }

        wp_reset_postdata();

        return $courses;
    }
}