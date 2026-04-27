
<div class="flex flex-col gap-[40px] l:gap-0 l:flex-row justify-between items-start l:items-end">
		<div class="footer-socials flex flex-row items-center gap-[26px]">
			<?php if($options['footer_socials']): ?>
				<?php $__currentLoopData = $options['footer_socials']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<a class="w-[40px] h-[40px] l:w-auto l:h-auto l:py-[9px] l:px-[16px] text-brand bg-white hover:text-white hover:bg-brand border border-white rounded-full text-sm flex justify-center items-center gap-2"
					   aria-label="<?php echo e($social['title']); ?>"
					   rel="noopener noreferrer" target="_blank"
					   href="<?php echo e($social['link']); ?>">
						<span class="hidden l:inline"><?php echo e($social['title']); ?></span>
					</a>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			<?php endif; ?>

		</div>

</div>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/footer/footer-contacts.blade.php ENDPATH**/ ?>