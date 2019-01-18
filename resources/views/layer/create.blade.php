@extends('shared.layout')
@section('title', 'Layer Baru')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Layer Baru
    </h1>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-plus"></i>
            Layer Baru
        </div>
        <div class="card-body">
            <form action="{{ route('layer.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class='form-group'>
                    <label for='name'> Nama: </label>
                
                    <input
                        id='name' name='name' type='text'
                        placeholder='Nama layer'
                        value='{{ old('name') }}'
                        class='form-control {{ !$errors->has('name') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('name') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='description'> Description: </label>
                
                    <textarea
                        id='description' name='description'
                        class='form-control {{ !$errors->has('description') ?: 'is-invalid' }}'
                        placeholder="Deskripsi layer"
                        col='30' row='6'
                        >{{ old('description') }}</textarea>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('description') }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="icon"> Icon: </label>
                    <input class="d-block" id="icon" name="icon" type="file" accept="images/*">
                    <small class='text-danger text-xs mt-3'>
                        {{ $errors->first('icon') }}
                    </small>
                </div>

                <div class="form-group text-right mt-5">
                    <button class="btn btn-primary">
                        Tambahkan Layer
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection