{{-- Language bar --}}
@php
	$list = pll_the_languages( [ 'raw' => 1, 'hide_if_no_translation' => 1 ] ) ?? [];

@endphp
@if($list)
	<ul class="relative bg-black language-bar flex flex-col gap-2 items-center mr-8 lgx:mr-0">
	@foreach($list as $lang)
		@if($lang['current_lang'] === true)
			<li class="language language-current text-white flex flex-row gap-2">
				<span class="p-1">
					<img src="{{$lang['flag']}}" alt="{{$lang['name']}}}">
				</span>
			</li>
			<span class="absolute language-bar-toggle language-bar-toggle-js"></span>
		@endif
	@endforeach
		<ul class="absolute bg-black -bottom-[25px] left-0 flex flex-col gap-2 hidden language-bar-hidden-js">
		@foreach($list as $lang)
			@if($lang['current_lang'] !== true)
				<li class="text-white language flex flex-row gap-2">
					<a class="p-1" href="{{$lang['url']}}">
						<img src="{{$lang['flag']}}" alt="{{$lang['name']}}">
					</a>
				</li>
			@endif
		@endforeach
		</ul>
	</ul>
@endif
