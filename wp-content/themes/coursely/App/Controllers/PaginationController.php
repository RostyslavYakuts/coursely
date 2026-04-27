<?php

namespace coursely\App\Controllers;

class PaginationController
{
    public function __construct(){
        add_filter('paginate_links', [$this, 'paginationLinks']);
    }

    public function paginationLinks ($link){
        if(is_paged()){
            $link= str_replace('/page/1/', '/', $link);
        }
        return $link;
    }
    public static function generate_pagination($max_num_pages): string
    {
        $str = '<div class="mt-10 mx-auto max-w-[300px] pagination flex items-center justify-around">';
        $big = 999999999;
        $str .= paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'current' => max(1,get_query_var('paged')),
            'total' => $max_num_pages,
            'show_all'     => false,
            'prev_next' => true,
            'prev_text'    => __('<'),
            'next_text'    => __('>'),
            'before_page_number' => '',
            'after_page_number'  => '',
            'end_size' => 1,
            'mid_size' => 1
        ));

        $str .= '</div>';
        return $str;
    }

}