<?php
/**
* Template part Posts with ajax loading
*/
?>
<section id="what_we_do" class="what-we-do">
    <h2><span class="h2-decorated"></span>Recent Posts<span class="h2-decorated-2"></span></h2>
  <?php
    $args = array(
      'posts_per_page' => 5,
      'orderby' => 'post_date',
      'order'   => 'DESC',
      'post_type' => 'post',
      'post_status' => 'publish',
      'paged' => ( get_query_var('paged') ) ? absint(get_query_var('paged')) : 1,
    );

    $news = new WP_Query( $args );
    if($news->have_posts()){
      echo '<div class="news-posts">';
      while($news->have_posts()){
          $news->the_post();
          $current_news_id = get_the_ID();
          echo '<div class="news-item col-md-4"><a href="'.get_the_permalink().'">';

          echo '<span class="img-wrapper-child" style="background:url('. wp_get_attachment_image_src(get_post_thumbnail_id( $current_news_id ), 'medium')[0].') no-repeat;" ></span>';
          echo '<div class="news-item-content">';
          $news_title = get_the_title();
          if( get_field('title_h1') ){
              $news_title = get_field('title_h1');
          }
          echo'<h3>'.$news_title.'</h3>';
          echo '<p>'.get_the_excerpt().'</p>';
          echo '<span class="time">'.get_the_date('d F Y').'</span>';
          echo '</div>';
          echo '</a></div>';
      }
            if ( $news->max_num_pages > 1 ){
                $max_num_pages = $news->max_num_pages;
                $query_vars = $news->query_vars;
                $current_page = 2;
                echo '<div class="news-item load-more-wrapper col-md-4">
                <div id="loader" class="loader"></div>
          <span id="rw_show_more" class="load-more"
          data-max-pages="'.$max_num_pages.'"
          data-query-vars="'.serialize($query_vars).'"
          data-current-page="'. $current_page .'"
          >More news</span>
          </div>';
        }
  echo '</div>';
  }
?>
        </section>
