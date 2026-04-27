{{-- Category --}}
@extends('layout')

@section('content')
    @include('global.breadcrumbs',['wrapper'=>true])
    @include('taxonomy.tag.top-info')
    @include('taxonomy.tag.posts')
@endsection