@extends('shared.layout')
@section('title', 'Panorama Lokasi')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-image'></i>
        Panorama Lokasi '{{ $location->name }}'
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item"> <a href="{{ route('location.index') }}"> Lokasi </a> </li>
            <li class="breadcrumb-item active"> Panorama </li>
        </ol>
    </nav>

    @javascript('p_location', $location)

    <div id="app">
        <location-panorama-index
            :config="{{ json_encode(config("map")) }}"
            >
        </location-panorama-index>
    </div>

</div>
@endsection
