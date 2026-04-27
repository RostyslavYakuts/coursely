{{-- Category Block Single Post --}}
@php
	/**
	 * @var $categories
	 */
    if(!$categories) return;
@endphp
<div class="mt-6 flex gap-3 items-center flex-col xs:flex-row">
	<div class="flex flex-wrap gap-2">
		@foreach($categories as $category )
			<a class="transition block py-1 px-3 font-bold text-brand bg-brand-light rounded-2xl
			 hover:text-white hover:bg-brand border border-brand" href="{{$category['link']}}" rel="category">
				{{$category['name']}}
			</a>
		@endforeach
	</div>
</div>
