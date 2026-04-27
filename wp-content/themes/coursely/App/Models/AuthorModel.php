<?php

namespace coursely\App\Models;

class AuthorModel implements ModelInterface
{
    public \WP_User$author;

    public function __construct($author){
        $this->author = $author;
    }
    public function get_post_data(): array
    {
        $id = $this->author->ID;
        $first_name = $this->author->first_name;
        $last_name  = $this->author->last_name;
        $full_name  = trim($first_name . ' ' . $last_name) ?: $this->author->display_name;

        return [
            'id' => $id,
            'first_name'=> $first_name,
            'last_name' => $last_name,
            'full_name' => $full_name,
            'url'       => get_author_posts_url($id),
            'description' => $this->author->description,
            'about_author' => get_field('about_author','user_' . $id),
            'author_photo' => get_field('author_photo', 'user_' . $id),
            'author_articles'=>$this->get_all_author_posts($id)
        ];

    }

    public function get_all_author_posts(int $author_id = null, int $per_page = -1): array
    {

        $query = new \WP_Query([
            'author'         => $author_id,
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $per_page,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        $posts = [];
        foreach ($query->posts as $post) {
            $posts[] = [
                'id'        => $post->ID,
                'title'     => get_the_title($post->ID),
                'permalink' => get_permalink($post->ID),
                'date'      => get_the_date('F d, Y', $post->ID),
                'thumbnail' => get_the_post_thumbnail_url($post->ID, 'medium'),
            ];
        }

        return $posts;
    }

}