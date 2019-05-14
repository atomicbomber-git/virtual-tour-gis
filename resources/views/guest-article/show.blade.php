@extends('shared.layout-guest')
@section('title', 'Artikel')
@section('content')
<div class="container my-5">
    
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Virtual Tour </li>
            <li class="breadcrumb-item">
                <a href="{{ route('guest-article.index') }}">
                    Artikel
                </a>
            </li>
            <li class="breadcrumb-item active">
                Baca Artikel
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <div class="mb-5">
                <h1>
                    {{ $article->title }}
                    <div class="lead"> {{ $article->created_at }} </div>
                </h1>
                <hr class="mt-0">
            </div>

           {!! $article->content !!}
        </div>
    </div>
</div>
@endsection