<?php
/**
 * Template part Team Slider
 */
?>
<div id="owl-wwa" class="owl-carousel">

	<?php
	if( have_rows('who_we_are','option') ): ?>
		<?php while( have_rows('who_we_are','option') ):  the_row(); ?>
			<div class="item wwa-item animated">
				<div class="owl-slider-item-img">
					<?php
					$who_we_are_item_image = get_sub_field('who_we_are_item_image','option');
					if($who_we_are_item_image){
						echo '<img width="70" height="70" loading="lazy" data-src="'.$who_we_are_item_image['url'].'" class="owl-lazy" src="'.$who_we_are_item_image['url'].'" alt="'.$who_we_are_item_image['alt'].'">';
					}
					?>
				</div>
				<h4 class="owl-slider-item-h4"><?php echo get_sub_field('who_we_are_item_title','option'); ?></h4>
				<div class="owl-slider-item-hr"></div>
				<div class="owl-slider-item-p"><?php echo get_sub_field('who_we_are_item_description','option'); ?></div>
			</div>
		<?php endwhile; ?><?php else: ?>
	<?php endif; ?>
</div>
