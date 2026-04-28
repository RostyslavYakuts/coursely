
<nav class="main-menu main-menu-js hidden fixed px-5 l:px-[57px] z-10
l:relative l:flex l:items-center top-0 left-0 w-full l:w-auto l:top-inherit l:left:inherit">
	<div class="mt-[220px] lgx:mt-0 top-menu-wrapper flex flex-col gap-12 items-center l:flex-row relative">
		<?php
			wp_nav_menu([
                'theme_location' => 'main_menu',
                'menu_class' => 'text-lg top-menu lgx:text-brand relative z-10 l:gap-x-5 flex flex-col items-center justify-center mb-0 l:flex-row gap-y-5 l:gap-y-0 [&_a]:text-white [&_span]:text-white [&_a]:relative [&_a]:after:content-[""] [&_a]:after:absolute [&_a]:after:left-0 [&_a]:after:-bottom-1 [&_a]:after:w-0 [&_a]:after:h-[2px] [&_a]:after:bg-current [&_a]:after:transition-all [&_a:hover]:after:w-full',
                'container' => false,
            ]);
		?>

	</div>
	<div class="mt-[80px] flex lgx:hidden gap-x-2 justify-center items-center text-sm">
		<?php if(is_user_logged_in()): ?>
			<?php echo get_avatar(get_current_user_id(),40); ?>

		<?php else: ?>
			<button class="login-js brand-btn w-[70px] h-[41px] text-white bg-[#FFFFFF22] hover:bg-brand border border-[#FFFFFF33]">
				<?php echo e(__('Log in','coursely')); ?>

			</button>
			<a href="/pricing" class="brand-btn w-[81px] h-[41px] text-brand-dark  hover:bg-brand-dark hover:text-white bg-white">
				<?php echo e(__('Sign up','coursely')); ?>

			</a>
		<?php endif; ?>
	</div>

</nav>
<?php /**PATH /var/www/html/wp-content/themes/coursely/App/Views/global/header/top-menu.blade.php ENDPATH**/ ?>