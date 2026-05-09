

<section class="container">
    <div class="mt-[124px]">
        <h1 class="font-bold text-[48px]">
            <?php echo e(__('My Account','coursely')); ?>

        </h1>
    </div>

    <div class="relative account-settings my-10 bg-white rounded-[40px] brand-shadow p-6 flex flex-col lgx:flex-row gap-10 items-start">
       <?php echo $__env->make('page.account.tabs', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="account-tabs-content w-full hidden lgx:block bg-white p-5 border border-gray rounded-[20px]">
            <?php echo $__env->make('page.account.profile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('page.account.password', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php echo $__env->make('page.account.subscription', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>
    </div>

</section><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/account/hero.blade.php ENDPATH**/ ?>