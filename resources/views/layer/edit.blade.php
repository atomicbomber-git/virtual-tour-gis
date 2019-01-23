@extends('shared.layout')
@section('title', "Sunting Layer $layer->name")
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-pencil'></i>
        Sunting Layer '{{ $layer->name }}'
    </h1>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-pencil"></i>
            Sunting Layer '{{ $layer->name }}'
        </div>
        <div class="card-body">
            <form action="{{ route('layer.update', $layer) }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class='form-group'>
                    <label for='name'> Nama: </label>
                
                    <input
                        id='name' name='name' type='text'
                        placeholder='Nama'
                        value='{{ old('name', $layer->name) }}'
                        class='form-control {{ !$errors->has('name') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('name') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='description'> Deskripsi: </label>
                
                    <textarea
                        id='description' name='description'
                        class='form-control {{ !$errors->has('description') ?: 'is-invalid' }}'
                        col='30' row='6'
                        >{{ old('description', $layer->description) }}</textarea>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('description') }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="icon"> Icon Lama: </label>
                    <img class="d-block" src="{{ route('layer.icon', $layer) }}" alt="{{ $layer->name }}">
                </div>

                <div class="form-group">
                    <label for="icon"> Icon: </label>
                    <input class="d-block" id="icon" name="icon" type="file" accept="images/*">
                    <small class='text-danger text-xs mt-3'>
                        {{ $errors->first('icon') }}
                    </small>
                </div>

                <div class="form-group text-right">
                    <button class="btn btn-primary">
                        Ubah
                        <i class="fa fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection