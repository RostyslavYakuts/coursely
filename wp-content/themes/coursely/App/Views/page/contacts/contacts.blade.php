{{-- Contacts --}}
@extends('layout')

@section('content')

    @include('global.breadcrumbs',['wrapper'=>true])
    @include('page.contacts.hero')
    @include('page.contacts.form')
    @include('page.contacts.contact-info')
    @include('global.faq')
    @include('page.contacts.content')
@endsection