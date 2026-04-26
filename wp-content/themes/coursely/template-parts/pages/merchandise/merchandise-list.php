<?php
/**
 * Template part: Merchandise List
 * @package Merchandise Page
 */
?>
<section class="services-list">
	<h2><span class="h2-decorated"></span>All our merchandise<span class="h2-decorated-2"></span></h2>
	<div class="col-lg-12 services-list-items">
		<?php $proposition = new \WP_Query( array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'order'          => 'ASC',
			'orderby'        => 'date',
			'posts_per_page' => - 1
		) ); ?>
		<?php if ( $proposition->have_posts() ): ?><?php while ( $proposition->have_posts() ): $proposition->the_post(); ?>

			<div class="services-list-item products-list-item">
				<a href="<?php the_permalink(); ?>">
                    <span class="h3 flex-center"><?php the_title(); ?></span>
					<?php echo '<img width="150" height="150" loading="lazy"
					 data-src="' . get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) . '" 
					 src="' . get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) . '" 
					 alt="' . get_the_title() . '">'; ?>

				<div class="excerpt"><?php the_excerpt(); ?></div>
				<span class="details"><?php _e('show more','shibari_witch'); ?></span>
                </a>
			</div>
		<?php endwhile; ?>
		<?php else: ?>
		<?php endif;
		wp_reset_postdata();
		?>
	</div>
</section>
