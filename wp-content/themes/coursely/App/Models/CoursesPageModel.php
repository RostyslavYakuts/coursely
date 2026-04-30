<?php

namespace coursely\App\Models;

class CoursesPageModel implements ModelInterface
{
    public \WP_Post $post;
    public function __construct($post){
        $this->post = $post;
    }

    public function get_post_data(): array
    {
        $id = $this->post->ID;
        $content = apply_filters('the_content', get_the_content());
        $course_categories = CustomEntityModels::get_custom_terms('course_category') ?? [];

        return [
            'id'=>$id,
            'title'=>get_the_title($id),
            'thumbnail' => get_the_post_thumbnail(),
            'content' => $content,
            'h1'=>get_field('h1', $id) ?? '',
            'course_categories' => $course_categories,
            'default_courses' => $this->get_selected_courses(),
            'faq_title'=>get_field('faq_title', $id) ?? '',
            'faq_description'=>get_field('faq_description', $id) ?? '',
            'faq'=>get_field('faq', $id) ?? [],
        ];
    }

    private function get_selected_courses(int $page = 1): array
    {
        $query = new \WP_Query([
            'post_type'      => 'course',
            'posts_per_page' => 12,
            'paged'          => $page,
            'order'          => 'DESC'
        ]);

        if (!$query->have_posts()) {
            return [
                'items' => [],
                'has_more' => false
            ];
        }

        $courses = [];

        foreach ($query->posts as $post) {

            $terms = get_the_terms($post->ID, 'course_category');

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

        return [
            'items' => $courses,
            'has_more' => $page < $query->max_num_pages
        ];
    }

}