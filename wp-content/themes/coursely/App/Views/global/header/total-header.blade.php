{{-- Template Part Total Header --}}

<header class="total-header total-header-js relative z-30 flex h-[84px] w-full rounded-[40px]">
	<div class="container flex flex-row justify-between items-center text-white text-sm">

		@include('global.header.logotype',['options'=>$options])
		@include('global.header.top-menu',['options'=>$options])

		<div class="hidden lgx:flex gap-x-2 items-center text-sm">
			@if(is_user_logged_in())
				{!! get_avatar(get_current_user_id(),40) !!}
			@else
				<button class="login-js brand-btn w-[70px] h-[41px] text-white bg-[#FFFFFF22] hover:bg-brand border border-[#FFFFFF33]">
					{{__('Log in','coursely')}}
				</button>
				<a href="/pricing" class="brand-btn w-[81px] h-[41px] text-brand-dark  hover:bg-brand-dark hover:text-white bg-white">
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
