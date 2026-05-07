<?php

namespace coursely\App\Models;

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

        return [
            'id'=>$id,
            'title'=>get_the_title($id),
            'excerpt'=>get_the_excerpt($id),
            'thumbnail' => get_the_post_thumbnail($id,'full',['class'=>'w-[406px] h-[360px] object-cover rounded-[20px]']),
            'content' => $content,
            'recommended'=>$this->get_other_items($id,$parent_ids,$parent_data),
            'categories'=>$parent_data,
            'rating'=>get_field('rating', $id) ?? 5,
            'lessons_count'=>get_field('lessons_count', $id) ?? '',
            'duration'=>get_field('duration', $id) ?? '',
            'month_plan'=>$month_plan,
            'activate_subscription_link'=>get_field('activate_subscription_link', 'options') ?? '',
            'subscribe_features'=>[
                 __('Access to all courses','coursely'),
                 __('New courses included','coursely'),
                 __('Cancel anytime','coursely'),
            ],
            'modules' => $this->get_modules_with_lessons($id),
        ];
    }

    private function get_modules_with_lessons(int $course_id): array
    {
        $modules = get_field('modules', $course_id) ?? [];

        $lessons_query = get_posts([
            'post_type'      => 'lesson',
            'posts_per_page' => -1,
            'meta_query'     => [
                [
                    'key'   => 'course',
                    'value' => $course_id,
                    'compare' => '='
                ]
            ],
            'meta_key' => 'order',
            'orderby'  => 'meta_value_num',
            'order'    => 'ASC'
        ]);

        $grouped_lessons = [];

        foreach ($lessons_query as $lesson) {

            $module_id = get_field('module', $lesson->ID);

            $grouped_lessons[$module_id][] = [
                'id' => $lesson->ID,
                'title' => get_the_title($lesson->ID),
                'link' => get_permalink($lesson->ID),
                'order' => (int)get_field('order', $lesson->ID),
                'module' => $module_id,
            ];
        }

        foreach ($modules as &$module) {

            $module['lessons'] = $grouped_lessons[$module['id']] ?? [];

        }

        return $modules;
    }

    private function get_other_items($current_id,$parent_ids,$parent_data): array
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

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $id = get_the_ID();
                $items[] = [
                    'id' => $id,
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'link' => get_permalink(),
                    'thumbnail' => get_the_post_thumbnail_url($id, 'medium_large'),
                    'rating' => get_field('rating', $id),
                    'duration' => get_field('duration', $id),
                    'lessons_count' => get_field('lessons_count', $id),
                    'category' => $parent_data[0]['name']
                ];
            }
        }

        wp_reset_postdata();

        return $items;
    }
}