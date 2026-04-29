
<?php if($options): ?>
	<div class="flex justify-between items-center">
		<div class="max-w-[170px] flex flex-col gap-3 items-center justify-center">
			<img decoding="async" loading="lazy" width="184" height="46" src="<?php echo e($options['logo']['url'] ?? ''); ?>" alt="<?php echo e($options['logo']['alt'] ?? ''); ?>">
		</div>
	</div>
<?php endif; ?>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/footer/logotype.blade.php ENDPATH**/ ?>