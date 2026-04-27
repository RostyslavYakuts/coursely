
<?php
    /**
     * @var array $options
     */
?>
<footer id="footer"  class="w-full bg-brand-dark text-white py-[60px]">
    <div class="container mx-auto flex flex-col justify-between gap-[60px]">
        <?php echo $__env->make('global.footer.logotype', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('global.footer.footer-contacts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('global.footer.copyright', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</footer>
<?php
wp_footer();
?>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/footer/footer.blade.php ENDPATH**/ ?>