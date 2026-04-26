<?php
/**
 * Template part Hero
 * @package Merchandise
 */

$current_obj_id = get_queried_object_id();
$h1 = '';
if ( get_field( 'title_h1',$current_obj_id ) ) {
	$h1 = get_field( 'title_h1',$current_obj_id );
} else {
	$h1 = get_the_title($current_obj_id);
}
?>

<div class="service-hero">
	<h1><?php echo $h1; ?></h1>
	<span class="btn-scroll-down btn-scroll-down-js">
        <span class="btn-line btn-line-1"></span>
        <span class="btn-line btn-line-2"></span>
        <span class="btn-line btn-line-3"></span>
    </span>
</div>