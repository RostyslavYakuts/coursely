<?php

namespace coursely\App\Models;

class LessonModel implements ModelInterface
{
    public \WP_Post $post;
    public function __construct($post){
        $this->post = $post;
    }

    public function get_post_data(): array
    {
        $id = $this->post->ID;
        $content = apply_filters('the_content', get_the_content());

        return [
            'id'=>$id,
            'title'=>get_the_title($id),
            'excerpt'=>get_the_excerpt($id),
            'thumbnail' => get_the_post_thumbnail($id,'full',['class'=>'w-[406px] h-[360px] object-cover rounded-[20px]']),
            'content' => $content,
        ];
    }
}