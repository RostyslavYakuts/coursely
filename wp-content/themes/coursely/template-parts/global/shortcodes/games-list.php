<?php
/**
 * Created by PhpStorm.
 * User: Ростислав
 * Date: 13.10.2019
 * Time: 10:51
 */

$args = array(
    'posts_per_page' => 100,
    'post_type' => 'game',
);

$games = new WP_Query($args);
if($games->have_posts()){
    echo '<div class="games-list">';
    while($games->have_posts()){
        $games->the_post();
        $url_review = get_field('review_page_url');
        if($url_review){
            echo '
                <div class="game-item">
                    <a href="'.$url_review.'" class="thumbnail-wrapper">';
            the_post_thumbnail();
            echo '<span class="show-all-btn">Show all</span>
                    </a>';
            echo '<div class="content-wrapper">';
            echo '<a href="'.$url_review.'">';
            the_title('<h3>','</h3>');
            echo '</a>';
            the_excerpt();
            echo '</div>';
            echo '
                </div>';
        }
    }
    echo '</div>';
}
