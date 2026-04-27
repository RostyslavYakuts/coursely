{{-- Blog Page --}}
@extends('layout')

@section('content')
    @include('global.breadcrumbs',['wrapper'=>true])
    @include('page.blog.hero')
    @include('page.blog.top-articles')
    @include('page.blog.articles')
    @include('page.blog.content')
@endsection

