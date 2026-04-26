<?php
/**
* Template part Widgets
*/

$pateron_link = '';
if( get_field('pateron_link','option') ){
    $pateron_link = get_field('pateron_link','option');
}
$pateron_text = '';
if( get_field('pateron_text','option') ){
    $pateron_text = get_field('pateron_text','option');
}
$pateron_title = '';
if( get_field('pateron_title','option') ){
    $pateron_title = get_field('pateron_title','option');
}

?>
<div class="clearfix"></div>
		<section class="shibari-widgets">
            <h2><span class="h2-decorated"></span><?php echo $pateron_title; ?><span class="h2-decorated-2"></span></h2>
            <div class="shibari-widgets-items">
                <p class="h3"><?php echo $pateron_text; ?></p>
                <a class="brand-btn" href="<?php echo $pateron_link; ?>" target="_blank" rel="nofollow">Visit Onlyfans</a>
				<?php //if(!dynamic_sidebar('sidebar')) : ?>
				<?php //endif; ?>
			</div>
</section>
