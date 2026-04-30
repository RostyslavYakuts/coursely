{{-- Courses Page --}}
@extends('layout')

@section('content')
    @include('global.breadcrumbs',['wrapper'=>true])
    @include('page.courses.courses')
    @include('page.courses.faq')
@endsection

