{{-- Post --}}
@extends('layout')

@section('content')
	@include('global.breadcrumbs',['wrapper'=>true])
	@include('single.post.content')
	@include('single.post.recommended')
@endsection
