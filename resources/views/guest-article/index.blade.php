@extends('shared.layout-guest')
@section('title', 'Artikel')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-newspaper-o'></i>
        Artikel
    </h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> SIG Virtual Tour </li>
            <li class="breadcrumb-item active"> Artikel </li>
        </ol>
    </nav>

    @foreach ($articles as $article)
    <div class="card mb-3">
        <div class="card-body">
            <h2 class="h4"> {{ $article->title }} </h2>
            <span class="text-muted">
                {{ $article->created_at }}
            </span>

            <div class="d-flex justify-content-end">
                <a class="btn btn-dark btn-sm" href="{{ route('guest-article.show', $article) }}">
                    Baca Artikel
                </a>
            </div>
        </div>
    </div>
    @endforeach

    <div class="d-flex justify-content-center">
        <div class="flex-fill">
            Menampilkan hasil ke-{{ $articles->firstItem() }} hingga ke-{{ $articles->lastItem() }} dari {{ $articles->count() }} hasil yang ada.
        </div>

        <div class="flex-fill d-flex justify-content-end">
            {{ $articles->links() }}
        </div>
    </div>

</div>
@endsection