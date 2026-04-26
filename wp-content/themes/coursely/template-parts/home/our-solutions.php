<?php
/**
* Template part Our Solutions
*/
?>
<div class="os-wrapper">
  <div class="container">
    <div class="col-md-12 product-items">
      <h2>Our software and solutions</h2>
      <?php
        $args = array(
          'posts_per_page' => 3,
          'orderby'   => 'date',
          'order' => 'ASC',
          'post_status' => 'publish',
					'post_type' => 'product',
        );
        $products = new WP_Query($args);
        if($products->have_posts()){
          echo '<div class="flex-space-between items-wrapper">';
							while($products->have_posts()){
								$products->the_post();
								$data_id = get_the_ID();
								$title = get_field('product_title');
                $product_icon = get_field('product_icon');
                $short_products_description = get_field('short_products_description');
								echo '<a href="'.get_the_permalink().'" class="product-item" data-product-title="'.$title.'" data-product-id="'.$data_id.'">';
                  echo '<div class="product-item-top">';
                    if($product_icon){
                      echo '<img src="'.$product_icon['url'].'" alt="'.$product_icon['alt'].'">';
                    }else{
                      echo '<img src="'.bloginfo('template_directory').'/assets/images/default.png" alt="default icon">';
                    }
                    if($title){
                      echo '<h3>'. $title .'</h3>';
                    }
                    if($short_products_description){
                      echo '<p class="short-description">'.$short_products_description.'</p>';
                    }
							    echo '</div>';
                  echo '<p class="excerpt">'.get_the_excerpt().'</p>';
                  echo '<p class="view-details">View product details</p>';

								echo '</a>';
							}
              echo '</div>';
						}
            wp_reset_query();
      ?>
    </div>

  </div>
</div>
