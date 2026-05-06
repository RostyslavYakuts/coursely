
<?php if($data['recommended']): ?>
<div class="container mx-auto py-[50px]">

    <h2 class="text-3xl font-light text-center mb-14 tracking-wide">
        Рекомендуємо для Вас
    </h2>

    <div class="grid grid-cols-1 xs:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
        <?php $__currentLoopData = $data['recommended']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $product_id = $item['product'];
                $product = wc_get_product($product_id);
                if (!$product) continue;

                $image_id = $product->get_image_id();
                $image = wp_get_attachment_image_url($image_id, 'medium');
                $rating = 20 * (int)$product->get_average_rating();
            ?>

            <a href="<?php echo e(get_permalink($product_id)); ?>"
               class="group bg-white rounded-xl p-6 flex flex-col
                      transition duration-500
                      hover:shadow-2xl hover:-translate-y-2">

                    
                    <div class="overflow-hidden mb-6">
                        <img
                                src="<?php echo e($image); ?>"
                                alt="<?php echo e($product->get_name()); ?>"
                                class="w-full h-[240px] object-contain
                                                   transition duration-700
                                                   group-hover:scale-105"
                        >
                    </div>

                    
                    <h3 class="text-center text-lg font-medium
                               tracking-wide mb-3
                               group-hover:text-brand transition">
                        <?php echo e($product->get_name()); ?>

                    </h3>

                    
                    <div class="flex justify-center mb-3">
                        <?php echo $__env->make('global.star-rating',['rating'=>$rating], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>

                    
                    <div class="text-center mb-6">
                        <span class="text-xl font-light text-black">
                            <?php echo $product->get_price_html(); ?>

                        </span>
                    </div>

                    
                    <span class="mt-auto text-center border border-brand rounded
                                                 py-3 uppercase text-sm tracking-widest
                                                 transition duration-300
                                                 group-hover:bg-brand
                                                 group-hover:text-white">
                                       Переглянути
                    </span>

            </a>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>
<?php endif; ?><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/single/post/recommended.blade.php ENDPATH**/ ?>