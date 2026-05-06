{{-- About Page Index --}}
@extends('layout')

@section('content')
    @include('global.breadcrumbs',['wrapper'=>true])
    @include('page.about.hero')
    @include('page.home.why-choose')
    @include('page.home.testimonials')
    @include('global.faq')
@endsection