
<div class="bg-white px-5 w-full py-[100px] flex flex-col items-center justify-center gap-6 text-center text-brand ">
   <h2 class="text-3xl"><?php echo e($data['brands_title']); ?></h2>
    <p class="w-full text-gray-600 text-lg max-w-2xl mx-auto"><?php echo e($data['brands_description']); ?></p>
    <?php if($data['brands']): ?>
    <div class="relative wrap h-[100px] overflow-hidden" id="marquee_slider">
        <div class="list w-full m-0 p-0 absolute flex gap-2" id="list">
            <?php $__currentLoopData = $data['brands']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <figure class="slide list__item grow-0 shrink-0 px-5 text-center w-[300px] h-[100px]">
                    <img loading="lazy" decoding="async" src="<?php echo e($item['image']['url']); ?>" alt="<?php echo e($item['image']['alt']); ?>"
                             width="300" height="100" class="object-contain w-[300px] h-[100px]">
                </figure>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/home/brands.blade.php ENDPATH**/ ?>