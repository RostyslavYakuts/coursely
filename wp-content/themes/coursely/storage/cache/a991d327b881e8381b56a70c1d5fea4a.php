

<div class="completed-lessons-wrapper">
    <div class="completed-lessons w-full mt-8 flex justify-between items-center gap-3">
        <div class="flex items-center w-full text-sm font-medium">
             <span class="block text-brand-text ">
                <?php echo e(__('Completed lessons','coursely')); ?>:
            </span>&nbsp;
            <span class="completed-lessons-count">
                <?php echo e($data['completed_lessons_count']); ?>

            </span>/
            <span class="total-lessons-count">
                <?php echo e($data['lessons_count']); ?>

            </span>
        </div>
        <div class="w-full text-sm text-end font-medium">
             <span class="completed-lessons-percent">
                <?php echo e($data['completed_lessons_percentage']); ?>%
            </span>
        </div>
    </div>
    <div class="completed-lessons-progress-bar-wrapper mt-2.5 bg-gray w-full h-[6px]">
        <div style="width: <?php echo e($data['completed_lessons_percentage']); ?>%"  class="completed-lessons-progress-bar h-full bg-brand">

        </div>
    </div>
</div><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/course-progress.blade.php ENDPATH**/ ?>