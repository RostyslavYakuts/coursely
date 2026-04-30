
<section class="w-full container mx-auto">
    <h1 class="font-bold text-center text-brand-dark text-[32px] lgx:text-[48px]  mt-10">
        <?php echo e($data['h1']); ?>

    </h1>
    <p class="mt-5 text-lg text-brand-text text-center">
        <?php echo e($data['description']); ?>

    </p>
    <?php echo $__env->make('global.pricing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</section><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/pricing/plans.blade.php ENDPATH**/ ?>