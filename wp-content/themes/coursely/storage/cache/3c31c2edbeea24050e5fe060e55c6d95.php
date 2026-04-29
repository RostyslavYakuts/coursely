
<section class="bg-[#0158D81A] w-full mt-[120px] rounded-[20px] lgx:rounded-[40px] lgx:px-5 pt-10 pb-14">
    <div class="container mx-auto">
        <div class="flex justify-between items-center">
            <h2 class="text-brand-dark text-[32px] lgx:text-[48px] "><?php echo e($data['pricing_section_title']); ?></h2>
            <a href="<?php echo e($data['pricing_section_cta_link']); ?>" class="hidden lgx:flex items-center justify-center w-full lgx:max-w-[250px] brand-btn-dark">
                <?php echo e($data['pricing_section_cta']); ?>

                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.1667 6L19 12M19 12L13.1667 18M19 12L5 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
    </div>
    <?php echo $__env->make('global.pricing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</section>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/home/pricing.blade.php ENDPATH**/ ?>