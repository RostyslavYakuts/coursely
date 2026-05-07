
<?php
    /**
    * @var array $data
    */
    use coursely\App\Core\Helpers\CourseCard;
    if(!$data['recommended']) return;
?>
<div class="container mx-auto py-[100px]">

    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold tracking-wide mb-4">
            <?php echo __('Courses You might be interested in','coursely'); ?>

        </h2>
    </div>

    <div class="courses-js mt-10 grid grid-cols-1 lgx:grid-cols-3 gap-8">
        <?php $__currentLoopData = $data['recommended']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo CourseCard::render($course); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

</div>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/single/course/recommended.blade.php ENDPATH**/ ?>