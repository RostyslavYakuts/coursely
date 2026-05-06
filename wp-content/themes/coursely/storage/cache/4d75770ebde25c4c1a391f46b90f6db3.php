
<?php
	/**
	 * @var $categories
	 */
    if(!$categories) return;
?>
<div class="mt-6 flex gap-3 items-center flex-col xs:flex-row">
	<div class="flex flex-wrap gap-2">
		<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<a class="transition block py-1 px-3 font-bold text-brand bg-brand-light rounded-2xl
			 hover:text-white hover:bg-brand border border-brand" href="<?php echo e($category['link']); ?>" rel="category">
				<?php echo e($category['name']); ?>

			</a>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
</div>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/single/post/category-block.blade.php ENDPATH**/ ?>