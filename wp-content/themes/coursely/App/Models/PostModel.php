<?php

namespace coursely\App\Models;

use coursely\App\Core\Features\TableOfContent;
use coursely\App\Core\Features\SocialSharer;

class PostModel extends CustomEntityModels implements ModelInterface
{
    public \WP_Post $post;
    public function __construct($post){
        $this->post = $post;
    }

    public function get_post_data(): array
    {
        $id = $this->post->ID;
        $author_id = $this->post->post_author;
        $content = apply_filters('the_content', get_the_content());
        $toc = new TableOfContent($content);
        $toc_list = $toc->generateIndex();
        $categories = $this->generate_related_terms($id,'category');
        $tags = $this->generate_related_terms($id,'post_tag');
        $social = SocialSharer::get_social_sharing_buttons($this->post);
        $first_name = get_the_author_meta('first_name', $author_id);
        $last_name  = get_the_author_meta('last_name', $author_id);
        $full_name  = trim($first_name . ' ' . $last_name);
        $author_photo = get_field('author_photo','user_'.$author_id);
        $author_photo_url = '';
        if ($author_photo) {
            $author_photo_url = wp_get_attachment_image_url($author_photo['ID'], [100,100]);
        }
        return [
            'id'=>$id,
            'title'=>get_the_title($id),
            'thumbnail' => get_the_post_thumbnail(),
            'content' => apply_filters('the_content', get_the_content()),
            'categories'=>$categories,
            'tags'=>$tags,
            'social'=>$social,
            'toc'=>$toc_list,
            'datetime'=>get_the_date('c', $id),
            'date'=>get_the_date('F d Y',$id),
            'modified_date' => get_the_modified_date('F d Y', $id),
            'modified_datetime' => get_the_modified_date('c', $id),
            'author_id' => $author_id,
            'author_name' => $full_name,
            'author_url' => get_author_posts_url($author_id),
            'author_photo_url' => $author_photo_url,
            'recommended'=>get_field('recommended',$id) ?? []
        ];
    }

    public static function get_entity_model(): array
    {
        return[];
    }
}