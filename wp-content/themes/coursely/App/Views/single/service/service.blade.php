{{-- Service --}}
@extends('layout')

@section('content')
	@include('global.breadcrumbs',['wrapper'=>true])
	@include('single.service.content')
	@include('single.service.recommended')
@endsection
