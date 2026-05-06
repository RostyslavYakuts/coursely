{{-- Course --}}
@extends('layout')

@section('content')
	@include('global.breadcrumbs',['wrapper'=>true])
	@include('single.course.content')
	@include('single.course.recommended')
    @include('global.faq')
@endsection
