@extends('shared.layout')
@section('title', 'Kelola Layer')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-list-alt'></i>
        Layer
    </h1>

    @include('shared.alert')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> {{ config('app.name') }} </li>
            <li class="breadcrumb-item active"> Layer </li>
        </ol>
    </nav>

    <div class="my-3 text-right">
        <a href="{{ route('layer.create') }}" class="btn btn-dark btn-sm">
            Layer Baru
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-list-alt"></i>
            Layer
        </div>

        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-bordered'>
                   <thead class="thead thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Nama </th>
                            <th style="width: 40rem"> Deskripsi </th>
                            <th> <em> Icon </em> </th>
                            <th> Kendali </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($layers as $layer)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $layer->name }} </td>
                            <td> {{ $layer->description }} </td>
                            <td class="text-center">
                                <img
                                    width="20px" height="20px"
                                    src="{{ route('layer.icon', $layer) }}">
                            </td>
                            <td class="text-center">
                                <a href="{{ route('layer.edit', $layer) }}" class="btn btn-sm btn-dark">
                                    Sunting
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <form action='{{ route('layer.delete', $layer) }}' method='POST' class='d-inline-block'>
                                    @csrf
                                    <button
                                        @cannot("delete", $layer) disabled @endcannot
                                        type='submit' class='btn btn-danger btn-sm'>
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

        </div>
    </div>
</div>
@endsection
