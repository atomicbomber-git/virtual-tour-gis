@extends('shared.layout')
@section('title', 'Artikel Baru')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-plus'></i>
        Artikel Baru
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item">
                <a href="{{ route("article.index") }}">
                    Artikel
                </a>
            </li>
            <li class="breadcrumb-item active"> Artikel Baru </li>
        </ol>
    </nav>
    
    <div class="card">
        <div class="card-header">
            <i class="fa fa-plus"></i>
            Artikel Baru
        </div>
        <div class="card-body">
            <form method='POST' action='{{ route('article.store') }}'>
                @csrf
            
                <div class='form-group'>
                    <label for='title'> Judul: </label>
                
                    <input
                        id='title' name='title' type='text'
                        placeholder='Judul'
                        value='{{ old('title') }}'
                        class='form-control {{ !$errors->has('title') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('title') }}
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="content"> Konten: </label>
                    <textarea id="content" class="form-control" name="content" id="content" cols="30" rows="20"></textarea>
                    <div class='invalid-feedback'>
                        {{ $errors->first('content') }}
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary">
                        Tambahkan Artikel
                        <i class="fa fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section ('extra-scripts')
<script>
    tinyMCE.init({
        selector: '#content',
        body_class: 'tinymce-editor',
        plugins: 'lists,image,imagetools',
        image_caption: true,
        file_picker_callback: window.tinymce_file_picker_callback,
        height: 400,
        toolbar: [
            'undo redo | styleselect | bold italic | numlist bullist | alignleft aligncenter alignright | image'
        ],
        content_css: '{{ asset('css/app.css') }}',
    })
    .then(editors => {
        editors[0].setContent(`{!! old('content') !!}`)
    })
</script>
@endsection