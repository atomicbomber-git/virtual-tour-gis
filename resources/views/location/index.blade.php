@extends('shared.layout')
@section('title', 'Lokasi')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-map-marker'></i>
        Lokasi
    </h1>

    @include('shared.alert', ['state' => 'success', 'session_var' => 'message'])

    <div id="app">
        <location-index/>
    </div>
</div>

@javascript('layers', $layers)
@javascript('csrf_token', csrf_token())
@endsection