<?php
$args = array(
    'posts_per_page' => -1,
    'post_type' => 'slots',
);
echo '<div class="slots-list">';
$slots = new WP_Query($args);
if($slots->have_posts()){
    while($slots->have_posts()){
        $slots->the_post();
        $url = get_field('review_page_url');
        if($url){
            echo '
                <div class="slot-item">
                    <a href="'.$url.'" class="thumbnail-wrapper">';
            the_post_thumbnail();
            the_title('<h3>','</h3>');
            echo '<span class="learn-more-btn">Learn more</span></a>';
            echo '</div>';
        }
    }
}
echo '</div>';