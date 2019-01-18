@extends('shared.layout')
@section('title', 'Lokasi Baru')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Lokasi Baru
    </h1>

    <div id="app">
        <location-create/>
    </div>

    @javascript('layers', $layers)
</div>
@endsection