@extends('shared.layout')
@section('title', 'Kelola Layer')
@section('content')
<div class="container my-5">
    <h1 class='mb-5'>
        <i class='fa fa-list-alt'></i>
        Kelola Layer
    </h1>

    @include('shared.alert', ['state' => 'success', 'session_var' => 'message'])

    <div class="my-3 text-right">
        <a href="{{ route('layer.create') }}" class="btn btn-info">
            Layer Baru
            <i class="fa fa-plus"></i>
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fa fa-list-alt"></i>
            Kelola Layer
        </div>

        <div class="card-body">
            <div class='table-responsive'>
                <table class='table table-sm table-bordered'>
                   <thead class="thead thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Nama </th>
                            <th> Deskripsi </th>
                            <th> Kendali </th>
                        </tr>
                   </thead>
                   <tbody>
                       @foreach ($layers as $layer)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $layer->name }} </td>
                            <td> {{ $layer->description }} </td>
                            <td>
                                <a href="{{ route('layer.edit', $layer) }}" class="btn btn-sm btn-info">
                                    Sunting
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <form action='{{ route('layer.delete', $layer) }}' method='POST' class='d-inline-block'>
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

        </div>
    </div>
</div>
@endsection