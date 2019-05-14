@extends('shared.layout')
@section('title', 'Artikel')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-newspaper-o'></i>
        Artikel
    </h1>

    @include("shared.alert")

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item active"> Artikel </li>
        </ol>
    </nav>

    <div class="d-flex justify-content-end my-3">
        <a href="{{ route('article.create') }}" class="btn btn-dark btn-sm">
            <i class="fa fa-plus"></i>
            Artikel Baru
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-newspaper-o"></i>
            Artikel
        </div>
        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-bordered table-striped'>
                   <thead class='thead thead-dark'>
                        <tr>
                            <th> # </th>
                            <th> Judul </th>
                            <th class="text-center"> Kendali </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($articles as $article)
                        <tr>
                            <td>
                                {{ $loop->iteration }}.
                            </td>
                            <td>
                                {{ $article->title }}
                            </td>
                            <td class="text-center"> 
                                <a class="btn btn-dark btn-sm" href="{{ route("article.edit", $article) }}">
                                    Sunting
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <form action='{{ route('article.delete', $article) }}' method='POST' class='confirmed d-inline-block'>
                                    @csrf
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        Hapus
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                       @endforeach
                   </tbody>
                </table>
            </div>

            <div class="d-flex">
                <div class="text-left flex-fill">
                    Menampilkan hasil ke-{{ $articles->firstItem() }} hingga ke-{{ $articles->lastItem() }} 
                    dari {{ $articles->count() }} hasil yang ada.
                </div>
                <div class="d-flex justify-content-end flex-fill">
                    {{ $articles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection