{{-- Social Share --}}
<div class="mt-6 flex flex-col">
	<ul class="mt-2 flex flex-row flex-wrap justify-between items-center gap-1 text-2xl">
		@foreach($social as $link)
			<li>
				<a title="{{$link['title']}}" class=" max-w-[40px] h-auto text-brand block text-center p-2"
				   href="{{$link['href']}}" {{$link['attribute']}} rel="nofollow noreferrer noopener" target="_blank">
					{!! $link['icon'] !!}
				</a>
			</li>
		@endforeach
	</ul>
	<hr class="mt-4 text-brand ">
</div>
