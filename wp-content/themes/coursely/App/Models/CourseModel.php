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

        return [
            'id'=>$id,
            'title'=>get_the_title($id),
            'excerpt'=>get_the_excerpt($id),
            'thumbnail' => get_the_post_thumbnail($id,'full',['class'=>'w-[406px] h-[360px] object-cover rounded-[20px]']),
            'content' => $content,
            'recommended'=>$this->get_other_items($id,$parent_ids),
            'categories'=>$parent_data,
            'rating'=>get_field('rating', $id) ?? 5,
            'lessons_count'=>get_field('lessons_count', $id) ?? '',
            'duration'=>get_field('duration', $id) ?? '',
        ];
    }

    private function get_other_items($current_id,$parent_ids): array
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

                $items[] = [
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'excerpt' => get_the_excerpt(),
                    'link' => get_permalink(),
                    'thumbnail' => get_the_post_thumbnail(get_the_ID(), 'medium')
                ];
            }
        }

        wp_reset_postdata();

        return $items;
    }
}