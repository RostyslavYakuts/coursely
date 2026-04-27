{{-- Footer Socials --}}
<div class="flex flex-col gap-[40px] l:gap-0 l:flex-row justify-between items-start l:items-end">
		<div class="footer-socials flex flex-row items-center gap-[26px]">
			@if($options['footer_socials'])
				@foreach($options['footer_socials'] as $social)
					<a class="w-[40px] h-[40px] l:w-auto l:h-auto l:py-[9px] l:px-[16px] text-brand bg-white hover:text-white hover:bg-brand border border-white rounded-full text-sm flex justify-center items-center gap-2"
					   aria-label="{{$social['title']}}"
					   rel="noopener noreferrer" target="_blank"
					   href="{{$social['link']}}">
						<span class="hidden l:inline">{{$social['title']}}</span>
					</a>
				@endforeach
			@endif

		</div>

</div>
