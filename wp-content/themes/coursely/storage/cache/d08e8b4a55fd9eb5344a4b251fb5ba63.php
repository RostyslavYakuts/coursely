
<section class="my-[120px]">
    <div class="container mx-auto">
        <h2 class="text-center text-brand-dark text-[32px] lgx:text-[48px] ">
            <?php echo e($data['faq_title']); ?>

        </h2>
        <p class="mt-5 text-lg text-brand-text text-center">
            <?php echo e($data['faq_description']); ?>

        </p>

        <?php echo $__env->make('global.faq', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    </div>

</section><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/courses/faq.blade.php ENDPATH**/ ?>