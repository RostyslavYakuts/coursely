<?php
/**
 * Template part Team
 */
?>
<section class="c-team">
    <h2><span class="h2-decorated"></span>Our Team<span class="h2-decorated-2"></span></h2>
	<?php
	$team_description = get_field( 'team_description', 'option' );
	if ( $team_description ) {
		echo '<p>' . $team_description . '</p>';
	} else {
		echo '';
	}
	?>
    <div id="owl-team" class="owl-carousel c-team-items-wrapper">
		<?php

		$cteam = new WP_Query( array(
			'post_type'      => 'member',
			'post_status'    => 'published',
			'posts_per_page' => - 1,
			'meta_query'     => [
				'relation' => 'AND',
				[
					'key'   => 'member_status',
					'value' => true
				]
			]
		) );

		?>
		<?php if ( $cteam->have_posts() ): ?><?php while ( $cteam->have_posts() ): $cteam->the_post(); ?>
            <div class="c-team-item item animated">
                <a href="<?php the_permalink(); ?>">
                    <div class="c-team-item-img">
						<?php echo '<img width="250" height="250" loading="lazy" data-src="' . get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) . '" class="owl-lazy" src="' . get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) . '" alt="' . get_the_title() . '">'; ?>
                    </div>
                    <h4 class="c-team-item-h4 brand-color"><?php the_title(); ?></h4>
                    <div class="c-team-item-hr"></div>
                    <div class="red-italic"><?php echo get_the_excerpt(); ?></div>
                </a>
            </div>
		<?php endwhile; ?>
		<?php else: ?>
            <p></p>
		<?php endif; ?>
    </div>
</section>
