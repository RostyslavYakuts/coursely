<?php
 $href = home_url();
?>
<?php if(isset($options['header_logo'])): ?>

	<a class="relative z-10" aria-label="logo" href="<?php echo e($href); ?>">
		<img width="140"
			 height="44"
			 class="h-auto"
			 src="<?php echo e($options['header_logo']['url'] ?? ''); ?>"
			 alt="<?php echo e($options['header_logo']['alt'] ?? ''); ?>">
	</a>

<?php endif; ?>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/header/logotype.blade.php ENDPATH**/ ?>