<?php

namespace coursely\App\Models;

use coursely\App\Core\Features\TableOfContent;
use coursely\App\Core\Features\SocialSharer;

class ServiceModel implements ModelInterface
{
    public \WP_Post $post;
    public function __construct($post){
        $this->post = $post;
    }

    public function get_post_data(): array
    {
        $id = $this->post->ID;
        $content = apply_filters('the_content', get_the_content());
        $toc = new TableOfContent($content);
        $toc_list = $toc->generateIndex();
        $social = SocialSharer::get_social_sharing_buttons($this->post);


        return [
            'id'=>$id,
            'title'=>get_the_title($id),
            'thumbnail' => get_the_post_thumbnail(),
            'content' => apply_filters('the_content', get_the_content()),
            'social'=>$social,
            'toc'=>$toc_list,
            'recommended'=>$this->get_other_services($id)
        ];
    }

    public static function get_other_services($current_id): array
    {
        $args = [
            'post_type'      => 'service',
            'posts_per_page' => -1,
            'post__not_in'   => [$current_id],
            'orderby'        => 'rand'
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