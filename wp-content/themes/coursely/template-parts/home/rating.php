<?php
/**
* Template part Rating
*/
 ?>

 <section class="rating-wrapper">
     <?php if( get_field('rating_h2','options') ): ?>
     <h2><span class="h2-decorated"></span><?php echo get_field('rating_h2','options'); ?><span class="h2-decorated-2"></span></h2>
    <?php endif; ?>
  <?php if(have_rows('rating','option') ): ?>
  <div class="rating">
    <?php while(have_rows('rating','option')): the_row(); ?>
      <div class="rating-item animated">
        <div class="r-number"><?php echo get_sub_field('first_frase','option') ?></div>
          <div class="r-item-hr"></div>
          <div class="r-description"><?php echo get_sub_field('second_frase','option'); ?></div>
      </div>
		<?php endwhile; ?>
  </div>
  <?php endif; ?>
</section>
