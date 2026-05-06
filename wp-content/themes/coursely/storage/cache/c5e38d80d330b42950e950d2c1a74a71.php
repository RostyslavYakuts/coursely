
<?php
    /**
    * @var array $data
    */
    if(!$data['recommended']) return;
?>
<div class="container mx-auto py-[100px]">

    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold tracking-wide mb-4">
            <?php echo __('Courses You might be interested in','coursely'); ?>

        </h2>
    </div>

    <div class="grid md:grid-cols-3 gap-8">

        <?php $__currentLoopData = $data['recommended']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e($service['link']); ?>"
               class="group block bg-white rounded-xl overflow-hidden border border-gray-200
           hover:shadow-2xl transition-all duration-300">

                <div class="overflow-hidden">
                    <?php echo $service['thumbnail']; ?>

                </div>

                <div class="p-6">

                    <h3 class="text-xl font-semibold mb-3 group-hover:text-brand-accent transition-colors">
                        <?php echo e($service['title']); ?>

                    </h3>

                    <div class="flex items-center text-sm font-semibold text-brand-accent">
                        <?php echo __('Learn more','coursely'); ?>

                        <span class="ml-2 transform group-hover:translate-x-1 transition">
                        →
                    </span>
                    </div>

                </div>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </div>

</div>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/single/course/recommended.blade.php ENDPATH**/ ?>