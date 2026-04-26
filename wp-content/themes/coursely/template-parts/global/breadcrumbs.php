<?php
/**
 * Template part for breadcrumbs by Yoast SEO plugin
 * Created by PhpStorm.
 * User: Ростислав
 * Date: 12.01.2020
 * Time: 0:28
 */

    if( !is_front_page() && !is_404() ){
        if ( function_exists('yoast_breadcrumb') ) {
            yoast_breadcrumb( '<p id="breadcrumbs" class="breadcrumbs">','</p>' );
        }
    }
?>