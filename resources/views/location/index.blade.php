@extends('shared.layout')
@section('title', 'Lokasi')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-map-marker'></i>
        Lokasi
    </h1>

    <div id="app">
        <location-index/>
    </div>
</div>

@javascript('layers', $layers)
@endsection