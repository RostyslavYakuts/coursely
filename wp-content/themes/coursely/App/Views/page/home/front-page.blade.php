{{-- Front Page --}}
@extends('layout')
@section('content')

    @include('page.home.hero-section')
    @include('page.home.courses')
    @include('page.home.why-choose')
    @include('page.home.testimonials')
    @include('page.home.pricing')
    @include('page.home.faq')


@endsection

