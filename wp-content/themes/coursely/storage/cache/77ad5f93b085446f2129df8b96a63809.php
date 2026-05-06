
<section class="w-full container">
    <h1 class="font-bold text-center text-[32px] lgx:text-[48px]  mt-10">
        <?php echo e($data['h1']); ?>

    </h1>
    <p  class="mt-5 text-brand-text text-center text-lg">
        <?php echo $data['description']; ?>

    </p>

    <?php if($data['who_we_are']): ?>
        <div class="mt-10 flex flex-col gap-5 lg:gap-10">
            <?php $__currentLoopData = $data['who_we_are']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($index % 2 === 0): ?>
                    <?php $tw_class = 'flex-col lg:flex-row-reverse'; ?>
                <?php else: ?>
                    <?php $tw_class = 'flex-col lg:flex-row'; ?>
                <?php endif; ?>
                <div class="flex <?php echo e($tw_class); ?> gap-5 flex-start min-h-[440px]">
                    <img src="<?php echo e($item['image']['url']); ?>"
                         alt="<?php echo e($item['image']['alt']); ?>"
                         loading="lazy"
                         decoding="async"
                         width="650"
                         height="440"
                         class="brand-shadow rounded-[20px] object-cover w-full h-full "
                    >
                    <div class="p-5 lg:py-8 lgx:px-6 bg-white w-full rounded-[20px] brand-shadow">
                        <strong class="block font-bold text-[24px] ">
                            <?php echo e($item['title']); ?>

                        </strong>
                        <div class="mt-5 text-brand-text text-lg flex flex-col gap-2">
                            <?php echo $item['description']; ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>


</section><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/about/hero.blade.php ENDPATH**/ ?>