
<div class="w-full bg-white">
    <section id="statistic" class="container mx-auto py-[60px]">
        <div class="flex flex-col gap-6 mdx:flex-row justify-between items-start">
            <h2 class="text-3xl w-full text-brand-gold">
                <?php echo $data['statistic_section_title']; ?>

            </h2>
            <?php if($data['statistic_section_marks']): ?>
                <div class="w-full flex flex-col smx:flex-row justify-between items-start smx:items-center">
                    <?php $__currentLoopData = $data['statistic_section_marks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex flex-col gap-3 text-brand-gold">
                            <b data-statistic="<?php echo e($mark['mark']); ?>" class="animate-number-js text-4xl"></b>
                            <span class="uppercase"><?php echo e($mark['title']); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

    </section>
</div>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/home/statistic.blade.php ENDPATH**/ ?>