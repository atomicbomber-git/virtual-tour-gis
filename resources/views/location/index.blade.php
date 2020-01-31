@extends('shared.layout')
@section('title', 'Lokasi')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-map-marker'></i>
        Lokasi
    </h1>

    @include('shared.alert')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item active"> Lokasi </li>
        </ol>
    </nav>

    <div id="app">
        <location-index
            :config='{{ json_encode(config("map")) }}'
            >
        </location-index>
    </div>
</div>

@javascript('layers', $layers)
@javascript('csrf_token', csrf_token())
@endsection
