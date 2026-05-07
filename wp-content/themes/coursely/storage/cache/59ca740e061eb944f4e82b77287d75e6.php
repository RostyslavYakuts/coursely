

<div class="modules">
    <h2 class="text-[24px] font-bold">
        <?php echo e(__('What’s in this course?','coursely')); ?>

    </h2>
    <div class="course-statistic flex flex-row justify-between items-center">
        <div class="flex flex-row items-center gap-2 text-sm">
                <span><?php echo e($data['lessons_count']); ?> <?php echo e(__('lessons','coursely')); ?></span>
                <svg width="4" height="4" viewBox="0 0 4 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="4" height="4" rx="2" fill="#111230"/>
                </svg>
                <span><?php echo e($data['duration']); ?></span>
            </div>
        <button class="expand-all-modules-js font-medium">
                <?php echo e(__('Expand All Modules','coursely')); ?>

            </button>
    </div>
    <?php if($data['modules']): ?>
        <div class="mt-5 modules-wrapper flex flex-col gap-2">
            <?php $__currentLoopData = $data['modules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $active_css = '';
                    $style_attr = '';
                    if($key === 0){
                        $active_css = 'active';
                        $style_attr = 'style="display:block;"';
                    }
                ?>
                <div class="module <?php echo e($active_css); ?> flex flex-col gap-1">
                   <div class="module-title module-expandable-js bg-white rounded-[20px] p-5 flex justify-between items-center">
                         <span class="font-bold text-lg">
                            <?php echo e($module['title']); ?>

                         </span>
                         <span class="flex flex-row items-center gap-5">
                        <span>
                            <?php echo e($module['lessons_count']); ?> <?php echo e(__('lessons','coursely')); ?>

                        </span>
                        <svg class="module-title-arrow" width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.8806 0.29214C10.4913 -0.0971328 9.86025 -0.0974767 9.47055 0.291371L5.58594 4.16752L1.70132 0.291371C1.31162 -0.0974769 0.680594 -0.0971327 0.291322 0.29214C-0.0982513 0.681713 -0.0982511 1.31334 0.291322 1.70291L4.87883 6.29042C5.26935 6.68094 5.90252 6.68094 6.29304 6.29042L10.8806 1.70291C11.2701 1.31334 11.2701 0.681713 10.8806 0.29214Z" fill="#111230"/>
                        </svg>
                    </span>
                   </div>

                    <?php if($module['lessons']): ?>
                   <div <?php echo $style_attr; ?> class="module-lessons">
                       <?php $__currentLoopData = $module['lessons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php if($lesson['module'] === $module['id']): ?>
                           <div class="module-lesson flex items-center gap-2 px-5 py-3">
                               <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                   <path fill-rule="evenodd" clip-rule="evenodd" d="M3.23223 1.56561C3.70107 1.09677 4.33696 0.833374 5 0.833374H11.6667C11.8877 0.833374 12.0996 0.921171 12.2559 1.07745L17.2559 6.07745C17.4122 6.23373 17.5 6.44569 17.5 6.66671V16.6667C17.5 17.3298 17.2366 17.9656 16.7678 18.4345C16.2989 18.9033 15.663 19.1667 15 19.1667H5C4.33696 19.1667 3.70107 18.9033 3.23223 18.4345C2.76339 17.9656 2.5 17.3298 2.5 16.6667V3.33337C2.5 2.67033 2.76339 2.03445 3.23223 1.56561ZM5 2.50004C4.77899 2.50004 4.56702 2.58784 4.41074 2.74412C4.25446 2.9004 4.16667 3.11236 4.16667 3.33337V16.6667C4.16667 16.8877 4.25446 17.0997 4.41074 17.256C4.56702 17.4122 4.77899 17.5 5 17.5H15C15.221 17.5 15.433 17.4122 15.5893 17.256C15.7455 17.0997 15.8333 16.8877 15.8333 16.6667V7.01189L11.3215 2.50004H5Z" fill="#111230"/>
                                   <path fill-rule="evenodd" clip-rule="evenodd" d="M11.6654 0.833374C12.1256 0.833374 12.4987 1.20647 12.4987 1.66671V5.83337H16.6654C17.1256 5.83337 17.4987 6.20647 17.4987 6.66671C17.4987 7.12694 17.1256 7.50004 16.6654 7.50004H11.6654C11.2051 7.50004 10.832 7.12694 10.832 6.66671V1.66671C10.832 1.20647 11.2051 0.833374 11.6654 0.833374Z" fill="#111230"/>
                                   <path fill-rule="evenodd" clip-rule="evenodd" d="M5.83203 10.8333C5.83203 10.3731 6.20513 10 6.66536 10H13.332C13.7923 10 14.1654 10.3731 14.1654 10.8333C14.1654 11.2936 13.7923 11.6667 13.332 11.6667H6.66536C6.20513 11.6667 5.83203 11.2936 5.83203 10.8333Z" fill="#111230"/>
                                   <path fill-rule="evenodd" clip-rule="evenodd" d="M5.83203 14.1667C5.83203 13.7065 6.20513 13.3334 6.66536 13.3334H13.332C13.7923 13.3334 14.1654 13.7065 14.1654 14.1667C14.1654 14.6269 13.7923 15 13.332 15H6.66536C6.20513 15 5.83203 14.6269 5.83203 14.1667Z" fill="#111230"/>
                                   <path fill-rule="evenodd" clip-rule="evenodd" d="M5.83203 7.49996C5.83203 7.03972 6.20513 6.66663 6.66536 6.66663H8.33203C8.79227 6.66663 9.16536 7.03972 9.16536 7.49996C9.16536 7.9602 8.79227 8.33329 8.33203 8.33329H6.66536C6.20513 8.33329 5.83203 7.9602 5.83203 7.49996Z" fill="#111230"/>
                               </svg>
                               <strong class="text-lg"><?php echo e($lesson['title']); ?></strong>
                           </div>
                           <?php endif; ?>
                       <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </div>
                   <?php endif; ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>

<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/single/course/modules.blade.php ENDPATH**/ ?>