<?php
/**
 * The template for displaying the footer
 */
?>

<footer id="footer"  class="w-full bg-brand-dark text-white py-[60px]">
    <div class="container mx-auto flex flex-col justify-between gap-[60px]">
        <?php
        wp_nav_menu(
                array(
                        'theme_location' => 'footer_menu',
                        'container' => false,
                        'menu_class' => '',
                        'before' => '',
                        'after' => ''
                )
        );
        get_template_part('template-parts/footer/web','wiki');
        ?>
        <span class="footer-w-b">All rights reserved &copy; <?php echo date("Y"); ?>
        </span>
    </div>
</footer>
</main>
<?php wp_footer(); ?>
</body>
</html>
