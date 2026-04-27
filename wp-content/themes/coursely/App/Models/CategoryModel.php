<?php

namespace coursely\App\Models;

class CategoryModel implements ModelInterface
{
    public \WP_Term $obj;
    public function __construct($obj){
        $this->obj = $obj;
    }
    public function get_post_data(): array
    {
        $id = $this->obj->term_id;
        $similar_categories = get_terms([
                'taxonomy'   => 'category',
                'exclude'   => $id,
                'hide_empty' => true,
                'orderby'    => 'name',
                'order'      => 'ASC',
        ]);

        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        return [
            'id' => $id,
            'name'=>$this->obj->name,
            'description'=>$this->obj->description,
            'similar_categories'=>$similar_categories,
            'default_posts'=>$this->getDefaultPosts($paged),
            'image'=>get_field('image','term_' . $this->obj->term_id) ?? [],
            'recommended'=>get_field('recommended', 'term_' . $this->obj->term_id) ?? [],
        ];

    }


    public function getDefaultPosts($paged): \WP_Query
    {
        $args = array(
            'posts_per_page' => 6,
            'order'          => 'DESC',
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'paged'          => $paged,
            'tax_query'      => [
                [
                    'taxonomy'         => 'category',
                    'field'            => 'term_id',
                    'terms'            => $this->obj->term_id,
                    'include_children' => true,
                ],
            ],
        );
        return new \WP_Query( $args );
    }
}