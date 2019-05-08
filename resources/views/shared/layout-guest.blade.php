@extends('shared.layout-base')

@section('extra-head')
    <link rel="stylesheet" href="{{ asset('css/app-guest.css') }}">
@endsection

@section('body')
    @include('shared.navbar-guest')
    @yield('content')
@endsection
