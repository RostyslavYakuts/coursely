<?php

namespace coursely\App\Models;

use coursely\App\Core\Services\SubscriptionManager;

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
        $is_user_logged_in = is_user_logged_in();
        $h1 = get_field('h1', $id) ?? '';
        if($is_user_logged_in){
            $h1 = __('My Courses', 'coursely');
        }
        $user_course_filter_items = [];
        if($is_user_logged_in){
            $user_id = get_current_user_id();
            $completed_lessons = SubscriptionManager::getUserCompletedLessonsMap($user_id);
            $user_course_filter_items = $this->buildUserCourseFilterItems($completed_lessons);
        }
        return [
            'id'=>$id,
            'title'=>get_the_title($id),
            'thumbnail' => get_the_post_thumbnail(),
            'content' => $content,
            'h1'=>$h1,
            'course_categories' => $course_categories,
            'default_courses' => $this->get_selected_courses($is_user_logged_in),
            'is_user_logged_in' => $is_user_logged_in,
            'user_course_filter_items'=>$user_course_filter_items,
        ];
    }

    private function buildUserCourseFilterItems(array $completed_lessons): array
    {
        $course_ids = get_posts([
            'post_type'      => 'course',
            'posts_per_page' => -1,
            'fields'         => 'ids',
        ]);

        $lessons_map = [];
        foreach ($course_ids as $course_id) {
            $lessons_map[$course_id] = (int) get_field('lessons_count', $course_id);
        }

        $not_started = 0;
        $active = 0;
        $completed = 0;

        foreach ($course_ids as $course_id) {

            $done = (int) ($completed_lessons[$course_id] ?? 0);
            $total = $lessons_map[$course_id] ?? 0;

            if ($done === 0) {
                $not_started++;
                continue;
            }

            if ($total > 0 && $done >= $total) {
                $completed++;
                continue;
            }

            $active++;
        }

        return [
            [
                'title' => __('All Courses', 'coursely'),
                'data_name' => 'all',
                'value' => count($course_ids),
            ],
            [
                'title' => __('Not yet started courses', 'coursely'),
                'data_name' => 'not_started',
                'value' => $not_started,
            ],
            [
                'title' => __('Active courses', 'coursely'),
                'data_name' => 'active',
                'value' => $active,
            ],
            [
                'title' => __('Completed courses', 'coursely'),
                'data_name' => 'completed',
                'value' => $completed,
            ],
        ];
    }

    private function get_selected_courses($is_user_logged_in, int $page = 1): array
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

        $completed_lessons = [];
        if($is_user_logged_in){
            $user_id = get_current_user_id();
            $completed_lessons = SubscriptionManager::getUserCompletedLessonsMap($user_id);
        }

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

            $completed_lessons_count = $completed_lessons[$post->ID] ?? 0;

            $courses[] = [
                'id' => $post->ID,
                'title' => get_the_title($post->ID),
                'excerpt' => get_the_excerpt($post->ID),
                'link' => get_permalink($post->ID),
                'thumbnail' => get_the_post_thumbnail_url($post->ID, 'medium_large'),
                'rating' => get_field('rating', $post->ID),
                'duration' => get_field('duration', $post->ID),
                'lessons_count' => get_field('lessons_count', $post->ID),
                'category' => $parent_category,
                'completed_lessons_count' => $completed_lessons_count
            ];
        }

        wp_reset_postdata();

        return [
            'items' => $courses,
            'has_more' => $page < $query->max_num_pages
        ];
    }

}