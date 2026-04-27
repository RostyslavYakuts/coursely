{{-- Author --}}

@extends('layout')

@section('content')
    @include('global.breadcrumbs',['wrapper'=>true])
    @include('author.content')
    @include('author.author-posts')
@endsection