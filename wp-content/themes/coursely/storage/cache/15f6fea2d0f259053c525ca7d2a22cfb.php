
<?php
use coursely\App\Core\Helpers\CourseCard;
    /**
     * @var array $data
     */
    $course_categories = $data['course_categories'];
    if(!$course_categories) return;
    $default_courses = $data['default_courses'];
    if(!$default_courses) return;
?>
<section class="w-full container mx-auto">
  <h2 class="text-center text-brand-dark text-[32px] lgx:text-[48px]  mt-[120px]">
      <?php echo e($data['courses_section_title']); ?>

  </h2>

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

  <a href="<?php echo e($data['courses_section_cta_link']); ?>" class="mt-10 mx-auto w-full lgx:max-w-[250px] flex items-center justify-center brand-btn-dark">
      <?php echo e($data['courses_section_cta']); ?>

      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M13.1667 6L19 12M19 12L13.1667 18M19 12L5 12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
  </a>

</section><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/home/courses.blade.php ENDPATH**/ ?>