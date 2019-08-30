@extends('shared.layout-guest')
@section('title', 'Beranda')
@section('content')

<header class="container mt-3">
    <div class="jumbotron">
        <h1 class="display-3"> Selamat Datang </h1>
        <p class="lead">
            {{ config('app.long_name') }}
        </p>
    </div>
</header>

<!-- Page Content -->
<div class="container">
    <h2 class="h3 mt-5 mb-1">
        <i class="fa fa-newspaper-o"></i>
        Artikel Terbaru
    </h2>
    <hr class="mt-1">
    <div class="row">

        @inject('formatter', 'App\Helpers\FormatterInterface')

        @foreach ($articles as $article)
        <div class="col-lg-4 mb-2 d-flex">
            <div class="card w-100">
                <div class="card-body">
                    <h5 class="card-title font-weight-bold text-primary mb-1">
                        {{ $article->title }}
                    </h5>
                    <span class="text-muted mt-1">
                        {{ $formatter->date($article->created_at) }}
                    </span>

                    <p class="card-text" style="height: 100px; overflow-y: hidden">
                        {{ $article->short_content }}
                    </p>

                    <div class="d-flex justify-content-end">
                        <a
                            href="{{ route('guest-article.show', $article) }}"
                            class="btn btn-primary btn-sm">
                            Baca
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        </div>
    </div>
</div>
<!-- /.container -->

@endsection
