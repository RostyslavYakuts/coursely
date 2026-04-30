<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('global.breadcrumbs',['wrapper'=>true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page.pricing.plans', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('page.pricing.faq', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/pricing/index.blade.php ENDPATH**/ ?>