
<?php if($data['user_course_filter_items']): ?>
<div class="user-courses-filter-items my-8 flex flex-col px-6 py-5 rounded-[20px] bg-white brand-shadow ">
   <div class="flex flex-col mdx:flex-row gap-5 ">
      <?php $__currentLoopData = $data['user_course_filter_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
         <div class="user-courses-filter-item py-2 mdx:pt-3 mdx:pb-5 text-lg font-bold <?php echo e($key === 0 ? 'active' : ''); ?> cursor-pointer" data-filter="<?php echo e($item['data_name'] ?? ''); ?>" data-value="<?php echo e($item['value']); ?>">
            <?php echo e($item['title']); ?>

            <span class="count">
            (<?php echo e($item['value']); ?>)
         </span>
         </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </div>
   <div class="hidden mdx:block w-full h-[1px] bg-gray"></div>

</div>
<?php endif; ?><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/courses/user-courses-filter.blade.php ENDPATH**/ ?>