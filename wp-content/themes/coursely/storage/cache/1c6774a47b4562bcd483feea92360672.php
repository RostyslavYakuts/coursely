
<?php
use coursely\App\Core\Helpers\CourseCard;
    /**
     * @var array $data
     */
    $course_categories = $data['course_categories'];
    if(!$course_categories) return;
    $default_courses = $data['default_courses']['items'];
    if(!$default_courses) return;

?>
<section class="w-full container mx-auto">
  <h1 class="font-bold text-center text-brand-dark text-[32px] lgx:text-[48px]  mt-10">
      <?php echo e($data['h1']); ?>

  </h1>

  <div class="course-categories-js mt-5 flex flex-row flex-wrap gap-4 justify-center items-center">
      <div data-id="all" class="active course-tab-js course-category rounded-full text-center lgx:text-lg p-3">
          <?php echo e(__('All categories','coursely')); ?>

      </div>
       <?php $__currentLoopData = $course_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div data-id="<?php echo e($category->term_id); ?>" class="course-tab-js course-category select-none min-w-[100px] rounded-full text-center lgx:text-lg p-3">
                <?php echo $category->name; ?>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
  <div class="courses-js mt-10 grid grid-cols-1 lgx:grid-cols-3 gap-8">
      <?php $__currentLoopData = $default_courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo CourseCard::render($course); ?>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

</section><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/courses/courses.blade.php ENDPATH**/ ?>