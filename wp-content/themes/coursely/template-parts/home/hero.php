<?php
/**
* Template part Hero
*/
?>
<div id="slider_block" class="slider-box">

    <?php
    $images = get_field('top_slider','options');
    if( $images ){
        echo '<div id="top_slider" class="owl-carousel owl-theme top-slider">';
        for( $i = 0; $i < count($images); $i++ ){
            echo '<div class="item">';
            echo '<img width="500" height="400" loading="lazy" data-src="'.$images[$i]['url'].'" class="owl-lazy" src="'.$images[$i]['url'].'" alt="'.$images[$i]['alt'].'">';
            echo '</div>';
        }
        echo '</div>';
    }
    ?>
    <div class="top-caption">
        <?php if(have_posts()){
            while(have_posts()){
                the_post();
                $title_h1 = get_the_title();
                if( get_field('title_h1') ){
                    $title_h1 = get_field('title_h1');
                }
                $h2 = 'Anna Leontieva shibari art studio';
                if( get_field('home_page_hero_title','option') ){
                    $h2 = get_field('home_page_hero_title','option');
                }
                echo '<h1 class="slide-h2">'. $title_h1 .'</h1>';
                echo '<p class="slide-h1">'. $h2 .'</p>';
                echo '<span id="hero_cta" class="brand-btn hero-cta hero-cta-js">Select service</span>';

                the_content();
            }
        }
        ?>



    </div>
    <?php  get_template_part('template-parts/home/hero','form'); ?>
<span class="hero-btn-scroll-down hero-btn-scroll-down-js"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
</div>

