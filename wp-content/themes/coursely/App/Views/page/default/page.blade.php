{{-- Post --}}
@extends('layout')

@section('content')

	<div class="mx-auto container flex flex-col md:flex-row flex-wrap gap-8 mt-[204px] mb-[120px]">

		<div class="flex flex-col gap-6">
			<h1 class="text-[36px] l:text-[48px]">{{$title}}</h1>
			{!! $thumbnail !!}
		</div>

		<div class="flex flex-col prose prose-base w-full max-w-[100%]">
			{!! $content !!}
		</div>


	</div>
@endsection
