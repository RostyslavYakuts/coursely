{{-- Pricing Page --}}
@extends('layout')

@section('content')
    @include('global.breadcrumbs',['wrapper'=>true])
    @include('page.pricing.plans')
    @include('global.faq')
@endsection

