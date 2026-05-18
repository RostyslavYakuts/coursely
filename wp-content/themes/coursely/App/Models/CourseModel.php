<?php

namespace coursely\App\Models;

use coursely\App\Core\Services\CourseProgressService;
use coursely\App\Core\Services\SubscriptionManager;

class CourseModel implements ModelInterface
{
    public \WP_Post $post;
    public function __construct($post){
        $this->post = $post;
    }

    public function get_post_data(): array
    {
        $id = $this->post->ID;
        $terms = wp_get_post_terms($id, 'course_category');
        $parent_ids = [];
        $parent_data = [];

        foreach ($terms as $term) {
            $parent_id = $term->parent ?: $term->term_id;

            $parent_term = $term->parent
                ? get_term($term->parent, 'course_category')
                : $term;

            if (!$parent_term || is_wp_error($parent_term)) {
                continue;
            }

            $parent_ids[] = $parent_id;

            $parent_data[] = [
                'id'   => $parent_term->term_id,
                'name' => $parent_term->name,
                'link' => get_term_link($parent_term),
            ];
        }

        $parent_ids = array_unique($parent_ids);
        $content = apply_filters('the_content', get_the_content());
        $plans = get_field('plans','options') ?? [];
        $month_plan = $plans[0]['price'] ?? 8.99;
        $current_user_id = get_current_user_id();
        $lessons_count = (int) (get_field('lessons_count', $id) ?? 0);

        $completed_lessons = CourseProgressService::getCompletedLessons($current_user_id, $id);
        $completed_lessons_count = count($completed_lessons) ?? 0;
        $completed_lessons_percentage = $lessons_count ? (int)round(($completed_lessons_count / $lessons_count) * 100) : 0;

        $modules = get_field('modules', $id) ?? [];
        $all_module_lessons = $this->get_lessons_from_module($modules);

        $first_lesson_link = get_the_permalink($all_module_lessons[0]);
        $next_lesson_link = $this->get_next_lesson_link($all_module_lessons,$completed_lessons);

        $cta_text = __('Start learning','coursely');
        $cta_link = $first_lesson_link;
        if($completed_lessons_percentage === 100){
            $cta_text = __('View Course','coursely');
        }
        if($completed_lessons_percentage > 0 && $completed_lessons_percentage < 100){
            $cta_text = __('Continue learning','coursely');
            $cta_link = $next_lesson_link;
        }
        $is_user_logged_in = is_user_logged_in();

        return [
            'id'=>$id,
            'title'=>get_the_title($id),
            'excerpt'=>get_the_excerpt($id),
            'thumbnail' => get_the_post_thumbnail($id,'full',['class'=>'w-[406px] h-[360px] object-cover rounded-[20px]']),
            'content' => $content,
            'recommended'=>$this->get_other_items($id,$parent_ids,$parent_data,$is_user_logged_in),
            'categories'=>$parent_data,
            'rating'=>get_field('rating', $id) ?? 5,
            'lessons_count'=>$lessons_count,
            'completed_lessons_count'=>$completed_lessons_count,
            'completed_lessons_percentage'=>$completed_lessons_percentage,
            'duration'=>get_field('duration', $id) ?? '',
            'month_plan'=>$month_plan,
            'activate_subscription_link'=>get_field('activate_subscription_link', 'options') ?? '',
            'subscribe_features'=>[
                 __('Access to all courses','coursely'),
                 __('New courses included','coursely'),
                 __('Cancel anytime','coursely'),
            ],
            'modules' =>  $modules,
            'is_user_logged_in'=>$is_user_logged_in,
            'current_user_id'=>$current_user_id,
            'is_user_subscription_active'=>SubscriptionManager::isActive($current_user_id),
            'cta_text'=>$cta_text,
            'cta_link'=>$cta_link
        ];
    }

    private function get_lessons_from_module(array $modules): array
    {
        $lessons = [];

        foreach ($modules as $module) {
            foreach (($module['lessons'] ?? []) as $lesson) {
                if (!empty($lesson['lesson'])) {
                    $lessons[] = (int) $lesson['lesson'];
                }
            }
        }

        return $lessons;
    }
    private function get_next_lesson_link(array $lessons,array $completed_lessons):string{
        $remaining_lessons = array_diff($lessons, $completed_lessons);
        $next_lesson_id = reset($remaining_lessons);
        return $next_lesson_id ? get_permalink((int) $next_lesson_id) : '';
    }
    private function get_other_items($current_id,$parent_ids,$parent_data,$is_user_logged_in): array
    {

        $args = [
            'post_type'      => 'course',
            'posts_per_page' => 3,
            'post__not_in'   => [$current_id],
            'orderby'        => 'rand',
            'tax_query'      => [
                [
                    'taxonomy' => 'course_category',
                    'field'    => 'term_id',
                    'terms'    => $parent_ids,
                    'include_children' => true
                ]
            ]

        ];

        $query = new \WP_Query($args);

        $items = [];
        $completed_lessons = [];
        if($is_user_logged_in){
            $user_id = get_current_user_id();
            $completed_lessons = SubscriptionManager::getUserCompletedLessonsMap($user_id);
        }

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $id = get_the_ID();
                $completed_lessons_count = $completed_lessons[$id] ?? 0;
                $items[] = [
                    'id' => $id,
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'link' => get_permalink(),
                    'thumbnail' => get_the_post_thumbnail_url($id, 'medium_large'),
                    'rating' => get_field('rating', $id),
                    'duration' => get_field('duration', $id),
                    'lessons_count' => get_field('lessons_count', $id),
                    'category' => $parent_data[0]['name'],
                    'completed_lessons_count' => $completed_lessons_count
                ];
            }
        }

        wp_reset_postdata();

        return $items;
    }
}