<?php

namespace coursely\App\Models;

class BlogModel implements ModelInterface
{
    public \WP_Post$page;

    public function __construct($page){
        $this->page = $page;
    }
    public function get_post_data(): array
    {
        $id = $this->page->ID;
        $h1 = get_field('h1', $id) ?: '';


        return [
            'id' => $id,
            'h1'=> $h1,
            'image'=>get_the_post_thumbnail($id,'full',['class'=>'w-full h-auto']),
            'description'=>get_field('description', $id)??'',
            'content'=>get_the_content($id),
            'top_articles_title'=>get_field('top_articles_title',$id) ??'',
            'top_articles_description'=>get_field('top_articles_description',$id) ??'',
            'top_articles'=>get_field('top_articles',$id) ??[],
            'all_articles'=>$this->get_all_articles(),
            'categories'=>$this->get_all_categories(),
            'tags'=>$this->get_all_tags(),
            'all_articles_section_title'=>get_field('all_articles_section_title',$id) ??'',
            'all_articles_section_description'=>get_field('all_articles_section_description',$id) ??'',
        ];

    }

    private function get_all_articles(): \WP_Query
    {
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $args = array(
            'posts_per_page' => 6,
            'order'          => 'DESC',
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'paged'          => $paged,
        );
        return new \WP_Query( $args );
    }

    private function get_all_categories(): array|\WP_Error|string
    {
        return get_terms([
            'taxonomy'   => 'category',
            'hide_empty' => true,
        ]);
    }
    private function get_all_tags(): array|\WP_Error|string
    {
        return get_terms([
            'taxonomy'   => 'post_tag',
            'hide_empty' => true,
        ]);
    }

}