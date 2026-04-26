<?php
/**
 * Template part Members widget
 * Created by PhpStorm.
 * User: Ростислав
 * Date: 23.01.2020
 * Time: 10:54
 */

 $members = new \WP_Query(array(
     'post_type' => 'member',
     'post_status'=>'published',
     'posts_per_page' => -1,
     'post__not_in' => array(get_the_ID()),
     'meta_query' => [
         'relation' => 'AND',
         [
             'key' => 'member_status',
             'value' => true
         ]
     ]
 )); ?>
<div class="members-widget-wrapper">
    <h3>Creative Shibari Witch team</h3>
    <div class="members-widget">
        <?php if($members->have_posts()): ?>
            <?php while($members->have_posts()): $members->the_post();?>
                <div class="c-team-item item">
                    <a href="<?php the_permalink(); ?>">
                    <div class="c-team-item-img">
                            <?php echo '<img data-src="'.get_the_post_thumbnail_url().'" class="owl-lazy" src="'.get_the_post_thumbnail_url().'" alt="'. get_the_title() .'">'; ?>
                    </div>
                    <h4 class="c-team-item-h4 brand-color"><?php the_title(); ?></h4>
                    <div class="c-team-item-hr"></div>
                    <div class="italic default-color"><?php echo get_the_excerpt(); ?></div>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
        <?php endif; ?>
    </div>
</div>
