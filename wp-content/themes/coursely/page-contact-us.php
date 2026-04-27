<?php
/**
 * Template Name: Contact Us
 */

use coursely\App\Controllers\FrontController;

if ( ! defined( 'ABSPATH' ) ) {
    die;
}
$current_obj = get_queried_object();
$front_controller = new FrontController();
$front_controller->handle($current_obj);
