{{-- Template Part Total Header --}}
@php
	$home = home_url();
@endphp
<header class="total-header total-header-js fixed top-0 left-0 z-30 flex h-[84px] w-full rounded-bl-[40px] rounded-br-[40px]">
	<div class="container flex flex-row justify-between items-center text-white text-sm">

		@include('global.header.logotype',['options'=>$options])
		@include('global.header.top-menu',['options'=>$options])

		<div class="hidden lgx:flex gap-x-2 items-center text-sm">
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
				<button class="login-js brand-btn w-[70px] h-[41px] text-white bg-[#FFFFFF22] hover:bg-brand border border-[#FFFFFF33]">
					{{__('Log in','coursely')}}
				</button>
				<a href="{{$home}}/pricing/" class="brand-btn w-[81px] h-[41px] text-brand-dark  hover:bg-brand-dark hover:text-white bg-white">
					{{__('Sign up','coursely')}}
				</a>
			@endif
		</div>

		<div class="flex l:hidden hamburger relative hamburger-js cursor-pointer w-[40px] h-[40px]">
			<span class="hamburger-line hamburger-top"></span>
			<span class="hamburger-line hamburger-middle"></span>
			<span class="hamburger-line hamburger-bottom"></span>
		</div>

	</div>
	@include('global.header.pop',['options'=>$options])
</header>
