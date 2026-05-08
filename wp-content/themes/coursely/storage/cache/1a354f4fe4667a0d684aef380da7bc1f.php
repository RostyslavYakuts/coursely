
<?php
	$home = home_url();
?>
<header class="total-header total-header-js fixed top-0 left-0 z-30 flex h-[84px] w-full rounded-bl-[40px] rounded-br-[40px]">
	<div class="container flex flex-row justify-between items-center text-white text-sm">

		<?php echo $__env->make('global.header.logotype',['options'=>$options], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
		<?php echo $__env->make('global.header.top-menu',['options'=>$options], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

		<div class="hidden lgx:flex gap-x-2 items-center text-sm">
			<?php if(is_user_logged_in()): ?>
				<a href="<?php echo e($home); ?>/account">
					<?php
						$user_id = get_current_user_id();
						$user_photo = get_field('user_photo','user_'.$user_id) ?? [];
                        $avatar = get_avatar($user_id,40);
					?>
					<?php if($user_photo): ?>
						<img class="rounded-full object-cover"
							 src="<?php echo e($user_photo['url']); ?>"
							 alt="user-<?php echo e($user_id); ?>" width="40" height="40">
					<?php else: ?>
					<?php echo $avatar; ?>

					<?php endif; ?>
				</a>
			<?php else: ?>
				<button class="login-js brand-btn w-[70px] h-[41px] text-white bg-[#FFFFFF22] hover:bg-brand border border-[#FFFFFF33]">
					<?php echo e(__('Log in','coursely')); ?>

				</button>
				<a href="<?php echo e($home); ?>/pricing/" class="brand-btn w-[81px] h-[41px] text-brand-dark  hover:bg-brand-dark hover:text-white bg-white">
					<?php echo e(__('Sign up','coursely')); ?>

				</a>
			<?php endif; ?>
		</div>

		<div class="flex l:hidden hamburger relative hamburger-js cursor-pointer w-[40px] h-[40px]">
			<span class="hamburger-line hamburger-top"></span>
			<span class="hamburger-line hamburger-middle"></span>
			<span class="hamburger-line hamburger-bottom"></span>
		</div>

	</div>
	<?php echo $__env->make('global.header.pop',['options'=>$options], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</header>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/header/total-header.blade.php ENDPATH**/ ?>