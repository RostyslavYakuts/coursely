{{-- Top Menu --}}
<nav class="main-menu main-menu-js hidden fixed px-5 l:px-[57px] z-10
l:relative l:flex l:items-center top-0 left-0 w-full l:w-auto l:top-inherit l:left:inherit">
	<div class="lgx:mt-0 top-menu-wrapper flex flex-col gap-12 items-center l:flex-row relative">
		@php
			wp_nav_menu([
                'theme_location' => 'main_menu',
                'menu_class' => 'text-lg top-menu lgx:text-brand relative z-10 l:gap-x-5 flex flex-col items-center justify-center mb-0 l:flex-row gap-y-5 l:gap-y-0 [&_a]:text-white [&_span]:text-white',
                'container' => false,
            ]);
		@endphp

	</div>
	<div class="mobile-login w-full flex lgx:hidden gap-x-2 justify-center items-center text-sm">
		@if(is_user_logged_in())
			<a href="{{$home}}/account">
				@php
					$user_id = get_current_user_id();
                    $user_photo = get_field('user_photo','user_'.$user_id) ?? [];
                    $avatar = get_avatar($user_id,40);
				@endphp
				@if($user_photo)
					<img class="rounded-full object-cover"
					     src="{{$user_photo['url']}}"
					     alt="user-{{$user_id}}" width="40" height="40">
				@else
					{!! $avatar !!}
				@endif
			</a>
		@else
			<button class="login-js brand-btn w-full h-[41px] text-white bg-[#FFFFFF22] hover:bg-brand border border-[#FFFFFF33]">
				{{__('Log in','coursely')}}
			</button>
			<a href="/pricing/" class="brand-btn w-full h-[41px] text-brand-dark  hover:bg-brand-dark hover:text-white bg-white">
				{{__('Sign up','coursely')}}
			</a>
		@endif
	</div>

</nav>
