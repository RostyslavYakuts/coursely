<?php
/**
* Recent Posts
*/
?>
<section class="recent-posts-wrapper">
<div class="container">
  <h2>Recent posts</h2>
  <?php
  $args = array(
	'posts_per_page' => 2,
	'orderby' => 'post_date',
  'order'   => 'DESC',
);

$query = new WP_Query( $args );
    if($query->have_posts()){
      echo '<div class="recent-posts flex-space-between">';
      while($query->have_posts()){
        $query->the_post();
        echo '<div class="recent-post col-md-6"><a href="'.get_the_permalink().'">';
        echo '<span class="img-wrapper-child" style="background:url('. get_the_post_thumbnail_url().') no-repeat;" ></span>';
        echo '<div class="recent-post-content">';
        echo '<span class="time">'.get_the_date('F Y').'</span>';
        echo'<h3>'.get_the_title().'</h3>';
        echo '<p>'.get_the_excerpt().'</p>';
        echo '</div></a></div>';
      }
      echo '</div>';
    }

  ?>
</div>
</section>
