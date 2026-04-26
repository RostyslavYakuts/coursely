<?php
/**
 * Template Part All products
 *
 */

$propositions = new WP_Query(array('post_type' => 'product','post__not_in' => array(get_the_ID()) )); ?>
<div class="members-widget-wrapper">
	<h3>Other products</h3>
	<div class="members-widget">
		<?php if($propositions->have_posts()): ?>
			<?php while($propositions->have_posts()): $propositions->the_post();?>
				<div class="c-team-item item">
					<div class="c-team-item-img">
						<a href="<?php the_permalink(); ?>">
							<?php echo '<img width="136" height="207" data-src="'.get_the_post_thumbnail_url().'" class="owl-lazy" src="'.get_the_post_thumbnail_url().'" alt="'. get_the_title() .'">'; ?>
						</a>
					</div>
					<h4 class="c-team-item-h4"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
				</div>
			<?php endwhile; ?>
		<?php else: ?>
		<?php endif; ?>
	</div>
</div>
