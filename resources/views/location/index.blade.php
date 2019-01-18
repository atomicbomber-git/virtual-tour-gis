@extends('shared.layout')
@section('title', 'Lokasi')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-map-marker'></i>
        Lokasi
    </h1>

    @include('shared.alert', ['state' => 'success', 'session_var' => 'message'])

    <div class="text-right my-4">
        <a href="{{ route('location.create') }}" class="btn btn-info">
            Lokasi Baru
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div id="app">
        <location-index/>
    </div>
</div>

@javascript('layers', $layers)
@javascript('csrf_token', csrf_token())
@endsection