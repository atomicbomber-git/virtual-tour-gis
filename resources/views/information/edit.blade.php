@extends('shared.layout')
@section('title', $information->title)
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class="fa {{ $information->icon }}"></i>
        {{ $information->title }}
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item active"> {{ $information->title }} </li>
        </ol>
    </nav>

    @include("shared.alert")

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('information.update', $information->type) }}">
                @csrf
                <div class="form-group">
                    <label for="content"> Konten: </label>
                    <textarea id="content" class="form-control" name="content" id="content" cols="30" rows="20"></textarea>
                    <div class='invalid-feedback'>
                        {{ $errors->first('content') }}
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary">
                        Ubah Data
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
    tinyMCE.init(Object.assign(window.tinymce_config, {
        content_css: '{{ asset('css/app.css') }}',
    }))
    .then(editors => {
        editors[0].setContent(`{!! old('content', $information->content) !!}`)
    })
</script>
@endsection

