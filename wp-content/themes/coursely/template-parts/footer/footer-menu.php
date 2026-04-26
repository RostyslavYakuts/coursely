<?php
/**
 * Footer menu template part
 */
?>
<div class="footer-menus col-lg-6 col-md-12">
    <?php if(has_nav_menu('footer_menu')) { ?>
        <nav class="footer-menu">
            <?php wp_nav_menu(array('container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' => 'footer_menu')); ?>
        </nav>
        <div class="hr"></div>
        <nav class="footer-menu">
            <?php wp_nav_menu(array('container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' => 'footer_menu_2')); ?>
        </nav>
        <nav class="footer-menu">
            <?php wp_nav_menu(array('container' => false, 'items_wrap' => '<ul>%3$s</ul>', 'theme_location' => 'footer_menu_3')); ?>
        </nav>
    <?php } ?>
</div>
