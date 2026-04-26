<?php
/**
* Template part Testimonials
*/
?>
<section class="testimonials">
            <h2><span class="h2-decorated"></span>Testimonials<span class="h2-decorated-2"></span></h2>
            <div class="viewport">
            <?php
             if(have_rows('testimonials','option') ): ?>
                <ul class="slidewrapper" data-current=0>
                    <?php while(have_rows('testimonials','option')): the_row();?>
                    <li class="slide">
                        <p><?php echo get_sub_field('author_text','option'); ?></p>
                        <h3><?php echo get_sub_field('author_name','option'); ?></h3>
                        <div><p><?php echo get_sub_field('author_role','option');  ?></p></div>
                    </li>
                    <?php endwhile; ?>
                </ul>
                <?php endif; ?>
            </div>
            <?php if(have_rows('testimonials','option') ): ?>
              <div class="toggles">
                <?php
                 while( have_rows('testimonials','option') ){
                   the_row();
                   $author_photo = get_sub_field('author_photo','option');
                   echo '<img class="dot" src="'.$author_photo['url'].'" alt="'.$author_photo['alt'].'">';
                 }
                 ?>
            </div>
            <?php endif; ?>
            <span id="prev_slide" class="arrows">←</span>
            <span id="next_slide" class="arrows">→</span>
</section>
