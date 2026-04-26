<?php
/**
 * Template part: Services List
 */
?>
<section class="services-list">
    <h2><span class="h2-decorated"></span>All our propositions<span class="h2-decorated-2"></span></h2>
    <div class="col-lg-12 services-list-items">
		<?php $proposition = new \WP_Query( array(
			'post_type'      => 'proposition',
			'post_status'    => 'publish',
			'order'          => 'ASC',
			'orderby'        => 'date',
			'posts_per_page' => - 1
		) ); ?>
		<?php if ( $proposition->have_posts() ): ?><?php while ( $proposition->have_posts() ): $proposition->the_post(); ?>

            <div class="services-list-item">
                <span class="h3 flex-center"><?php the_title(); ?></span>
                <a href="<?php the_permalink(); ?>">
					<?php echo '<img width="150" height="150" loading="lazy"
					 data-src="' . get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) . '"
					  src="' . get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) . '"
					   alt="' . get_the_title() . '">'; ?>
                </a>
                <div class="excerpt"><?php the_excerpt(); ?></div>
				<?php
				$rating_value = 0;
				$review_count = 0;
				if ( get_field( 'proposition_rating' ) ) {
					$rating_value = get_field( 'proposition_rating' );
				}
				if ( get_field( 'proposition_review_count' ) ) {
					$review_count = get_field( 'proposition_review_count' );
				}
				?>
                <div class="stars-rating-wrapper">
                    <div class="stars-rating">
                        <span class="stars-rating_inner" style="width: <?php echo $rating_value; ?>%"></span>
                    </div>
                    <div class="votes"><b><span class=""><?php echo $review_count; ?> </span></b> <span>Votes</span>
                    </div>
                </div>
                <span class="details order-btn-js" data-order="<?php echo get_the_ID(); ?>">get proposition</span>
            </div>
		<?php endwhile; ?>
		<?php else: ?>
		<?php endif;
		wp_reset_postdata();
		?>
    </div>
</section>
