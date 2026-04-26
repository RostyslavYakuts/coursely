<?php
/**
 * Template part Ropebook posts
 * Created by PhpStorm.
 * User: Ростислав
 * Date: 02.01.2020
 * Time: 9:01
 */
?>
<div class="col-md-12 rope-book-posts">
    <?php
    $args = array(
        'posts_per_page' => 8,
        'orderby' => 'post_date',
        'order'   => 'DESC',
        'post_type' => 'rbpost',
        'post_status' => 'publish',
        'paged' => ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1,
    );
    $rbpost = new \WP_Query($args);
    if($rbpost->have_posts()){
        echo '<div class="flex-space-between news-posts">';
        while($rbpost->have_posts()){
            $rbpost->the_post();
            echo '<div class="news-item col-md-4"><a href="'.get_the_permalink().'">';
            echo '<span class="img-wrapper-child" style="background:url('. get_the_post_thumbnail_url().') no-repeat;" ></span>';
            echo '<div class="news-item-content">';
            echo'<h3>'.get_the_title().'</h3>';
            echo '<p>'.get_the_excerpt().'</p>';
            echo '<span class="time">'.get_the_date('d F Y').'</span>';
            echo '</div>';
            echo '</a></div>';
        }
        if ( $rbpost->max_num_pages > 1 ){
            $max_num_pages = $rbpost->max_num_pages;
            $query_vars = $rbpost->query_vars;
            $current_page = 2;
            echo '<div class="news-item load-more-wrapper col-md-4">
                <div id="rb_loader" class="loader"></div>
          <span id="rb_show_more" class="load-more"
          data-max-pages="'.$max_num_pages.'"
          data-query-vars="'.serialize($query_vars).'"
          data-current-page="'. $current_page .'"
          >More posts</span>
          </div>';
        }
        echo '</div>';

    }
    wp_reset_query();
    ?>
</div>