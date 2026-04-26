<?php
/**
* Template part for Look Book block
*/
 ?>
 <section class="shibari-lookbook">
             <h2 id="h2shiblook"><span class="h2-decorated"></span>Shibari lookbook<span class="h2-decorated-2"></span></h2>
             <?php
                $lookbook_description = get_field('lookbook_description','option');
                if($lookbook_description){
                  echo '<p>'.$lookbook_description.'</p>';
                }
              ?>
             <?php wp_nav_menu(
                 array(
                     'theme_location' => 'lookbook_menu',
                     'container' => false
                 )
             );
             $services_widget_header = 'Most popular services';
             if( get_field('top_service_widget_header','option') ){
                 $services_widget_header =  get_field('top_service_widget_header','option');
             }
             ?>
 			<h3><?php echo $services_widget_header; ?></h3>
             <div class="gallery">
                 <?php
                 $most_popular_service = get_field('most_popular_service','option');
                 if($most_popular_service){
                    foreach($most_popular_service as $service ){
                        $thumbnail = get_field('proposition_thumbnail',$service->ID);
                        if($thumbnail){
                            echo '<div class="gallery-item animated">
                                 <img width="332" height="221" loading="lazy" src="'.$thumbnail['url'].'" alt="'.$thumbnail['alt'].'">
                                 <div class="gallery-item-description">
                                     <a href="'. get_the_permalink($service->ID) .'">
                                     <h4>'. get_the_title($service->ID) .'</h4>
                                     <p>'. get_the_excerpt($service->ID) .'</p>
                                     </a>
                                     <span class="brand-btn order-btn-js" data-order="'.$service->ID.'" >get proposition</span>
                                 </div>
                            </div>';
                        }
                    }
                 }
                 ?>
             </div>
         </section>
