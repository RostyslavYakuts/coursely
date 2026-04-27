{{-- Category --}}
@extends('layout')

@section('content')
    @include('global.breadcrumbs',['wrapper'=>true])
    @include('taxonomy.category.top-info')
    @include('taxonomy.category.posts')
@endsection