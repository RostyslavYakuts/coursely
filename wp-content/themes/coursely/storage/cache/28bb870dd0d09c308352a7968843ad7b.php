
<div class="mt-6 flex flex-col">
	<ul class="mt-2 flex flex-row flex-wrap justify-between items-center gap-1 text-2xl">
		<?php $__currentLoopData = $social; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li>
				<a title="<?php echo e($link['title']); ?>" class=" max-w-[40px] h-auto text-brand block text-center p-2"
				   href="<?php echo e($link['href']); ?>" <?php echo e($link['attribute']); ?> rel="nofollow noreferrer noopener" target="_blank">
					<?php echo $link['icon']; ?>

				</a>
			</li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</ul>
	<hr class="mt-4 text-brand ">
</div>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/social-share.blade.php ENDPATH**/ ?>