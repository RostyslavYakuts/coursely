{{-- Contacts --}}
@extends('layout')

@section('content')
    @include('page.contacts.hero')
    @include('global.breadcrumbs',['wrapper'=>true])
    @include('page.contacts.form')
    @include('page.contacts.content')
@endsection