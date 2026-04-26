<?php
/**
 * Template part: Team Widget
 */

$cteam = new \WP_Query( array(
	'post_type'      => 'member',
	'post_status'    => 'published',
	'order'          => 'ASC',
	'orderby'        => 'date',
	'posts_per_page' => - 1,
	'meta_query'     => [
		'relation' => 'AND',
		[
			'key'   => 'member_status',
			'value' => true
		]
	]
) );
if ( $cteam->have_posts() ): ?>
    <div class="team-widget-wrapper">
        <h2>Our creative Team</h2>
        <ul>
			<?php while ( $cteam->have_posts() ): $cteam->the_post(); ?>
                <li>
                    <a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail( 'thumbnail',array('loading' => 'lazy') ); ?>
                    </a>
                </li>
			<?php endwhile; ?>
        </ul>
        <p><?php echo get_services_team_info(); ?></p>
    </div>

<?php else: ?>

<?php endif;
wp_reset_query();
?>
