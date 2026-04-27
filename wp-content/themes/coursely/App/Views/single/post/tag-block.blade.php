{{-- Theme Block --}}
@php
	/**
	 * @var $tags
	 */
    if(!$tags) return;
@endphp
<div class="mt-6 flex gap-3 items-center flex-col xs:flex-row">
	<div class="flex flex-wrap">
		@foreach($tags as $tag )
			<a class="transition block py-1 px-3 font-bold underline hover:text-brand" href="{{$tag['link']}}" rel="tag">
				#{{$tag['name']}}
			</a>
		@endforeach
	</div>
</div>
