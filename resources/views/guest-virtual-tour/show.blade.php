@extends('shared.layout-guest')
@section('title', 'Peta')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class="fa fa-map"></i>
        Peta
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item active"> Peta </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body" id="app">
            <guest-virtual-tour
                :config='{{ json_encode(config('map')) }}'
                :layers='{{ json_encode($layers) }}'
                />
        </div>
    </div>
</div>
@endsection
