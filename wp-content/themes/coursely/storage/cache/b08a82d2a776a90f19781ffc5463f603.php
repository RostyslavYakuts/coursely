<?php $__env->startSection('content'); ?>

	<div class="mx-auto container flex flex-col md:flex-row flex-wrap gap-8 mt-[204px] mb-[120px]">

		<div class="flex flex-col gap-6">
			<h1 class="text-[36px] l:text-[48px]"><?php echo e($title); ?></h1>
			<?php echo $thumbnail; ?>

		</div>

		<div class="flex flex-col prose prose-base w-full max-w-[100%]">
			<?php echo $content; ?>

		</div>


	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/page/default/page.blade.php ENDPATH**/ ?>