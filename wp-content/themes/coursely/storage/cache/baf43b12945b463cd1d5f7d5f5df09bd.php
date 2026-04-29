
<?php
    /**
     * @var array $options
     */
?>
<div class="container">
    <div class="footer-banner relative z-20 -mb-[80px] rounded-[40px] py-[80px] w-full flex flex-col justify-center items-center gap-5 ">
        <h2 class="px-5 text-white font-bold text-center text-[32px] lgx:text-[48px] leading-none"><?php echo e($options['footer_banner_title']); ?></h2>
        <p class="px-5 text-lg text-white text-center"><?php echo e($options['footer_banner_description']); ?></p>
        <a href="<?php echo e($options['footer_banner_cta_link']); ?>" class="mt-3 bg-white flex justify-center items-center p-3 w-[200px] rounded-full border border-brand-gray text-lg hover:text-white hover:bg-brand-dark">
            <?php echo e($options['footer_banner_cta']); ?>

        </a>
    </div>
</div>

<footer id="footer"  class="w-full pt-[114px] bg-white rounded-tl-[40px] rounded-tr-[40px]">
    <div class="container mx-auto flex flex-col justify-between">
        <?php echo $__env->make('global.footer.logotype', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('global.footer.footer-contacts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php echo $__env->make('global.footer.copyright', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
</footer>
<?php
wp_footer();
?>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/footer/footer.blade.php ENDPATH**/ ?>