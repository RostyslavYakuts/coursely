
<?php
	/**
	 * @var $tags
	 */
    if(!$tags) return;
?>
<div class="mt-6 flex gap-3 items-center flex-col xs:flex-row">
	<div class="flex flex-wrap">
		<?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<a class="transition block py-1 px-3 font-bold underline hover:text-brand" href="<?php echo e($tag['link']); ?>" rel="tag">
				#<?php echo e($tag['name']); ?>

			</a>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
</div>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/single/post/tag-block.blade.php ENDPATH**/ ?>