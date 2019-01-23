@extends('shared.layout')
@section('title', 'Panorama Lokasi')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-image'></i>
        Panorama Lokasi
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Virtual Tour </li>
            <li class="breadcrumb-item"> <a href="{{ route('location.index') }}"> Lokasi </a> </li>
            <li class="breadcrumb-item active"> Panorama </li>
        </ol>
    </nav>

    @javascript('p_location', $location)

    <div id="app">
        <location-panorama-index/>
    </div>

    {{-- <div class="card mb-4">
        <div class="card-header">
            <i class="fa fa-plus"></i>
            Tambah Panorama Baru
        </div>
        <div class="card-body">
            <form action="{{ route('location.panorama.store', $location) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class='form-group'>
                    <label for='name'> Nama Panorama: </label>
                
                    <input
                        id='name' name='name' type='text'
                        placeholder='Nama Panorama'
                        value='{{ old('name') }}'
                        class='form-control {{ !$errors->has('name') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('name') }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="image"> Gambar: </label>
                    <input name="image" class="d-block" type="file" accept="image/*">
                </div>

                <div class="form-group text-right">
                    <button class="btn btn-primary">
                        Tambah Panorama
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="card">
        <div class="card-header">
            <i class="fa fa-image"></i>
            Daftar Panorama
        </div>
        <div class="card-body">
            @foreach ($location->panoramas as $panorama)
            <div class="mb-2">
                <figure class="figure">
                    <img
                        src="{{ route('location.panorama.image', [$location, $panorama]) }}"
                        class="figure-img img-fluid rounded" alt="{{ $panorama->name }}">
                    <figcaption class="figure-caption text-right">
                        {{ $panorama->name }}
                    </figcaption>
                </figure>
    
                <form action='{{ route('location.panorama.delete', [$location, $panorama]) }}' method='POST' class='d-inline-block'>
                    @csrf
                    <button type='submit' class='btn btn-danger btn-sm'>
                        <i class='fa fa-trash'></i>
                    </button>
                </form>
            </div>

            @endforeach
        </div>
    </div>
</div>
@endsection