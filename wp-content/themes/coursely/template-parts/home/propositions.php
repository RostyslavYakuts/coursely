<?php
/**
* Template part Our Propositions
*/
 ?>
 <div class="clearfix"></div>
        <section class="price-list">
            <h2><span class="h2-decorated"></span>Our  propositions<span class="h2-decorated-2"></span></h2>
            <p>what we are best at</p>
            <div id="owl_prices" class="owl-carousel owl-prices col-lg-12">
                <?php $price = new WP_Query(array('post_type' => 'proposition')); ?>
                <?php if($price->have_posts()): ?><?php while($price->have_posts()): $price->the_post(); ?>
                    <div class="item price-list-item animated">
                        <span class="h3 flex-center"><?php the_title(); ?></span>
                        <a href="<?php the_permalink(); ?>">
                            <?php echo '<img width="150" height="150" loading="lazy" data-src="'.get_the_post_thumbnail_url(get_the_ID(),'thumbnail').'" class="owl-lazy" src="'.get_the_post_thumbnail_url(get_the_ID(),'thumbnail').'" alt="'. get_the_title() .'">'; ?>
                        </a>
                        <div class="excerpt"><?php the_excerpt(); ?></div>
                            <?php
                                $rating_value = 0;
                                $review_count = 0;
                                if( get_field('proposition_rating') ){
                                    $rating_value =  get_field('proposition_rating');
                                }
                                if( get_field('proposition_review_count') ){
                                    $review_count = get_field('proposition_review_count');
                                }
                            ?>
                        <div class="stars-rating-wrapper">
                            <div class="stars-rating">
                                <span class="stars-rating_inner" style="width: <?php echo $rating_value; ?>%"></span>
                            </div>
                            <div class="votes"><b><span class=""><?php echo $review_count; ?> </span></b> <span>Votes</span></div>
                        </div>
                        <span class="details order-btn-js" data-order="<?php echo get_the_ID(); ?>" >get proposition</span>
                    </div>
                <?php endwhile; ?>
                <?php else: ?>
                    <p>Here is supposed to be the price item</p>
                <?php endif; ?>
            </div>
        </section>
