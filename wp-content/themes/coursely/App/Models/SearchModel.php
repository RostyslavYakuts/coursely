<?php

namespace coursely\App\Models;

class SearchModel implements ModelInterface
{

    public function get_post_data(): array
    {
        $query = get_search_query();

        $wp_query = new \WP_Query([
            's' => $query,
            'post_type' => ['post','service'],
            'posts_per_page' => 12,
        ]);

        return [
            'query' => $query,
            'posts' => $wp_query,
            'total' => $wp_query->found_posts
        ];
    }
}