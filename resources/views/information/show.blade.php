@extends('shared.layout-guest')
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

    <div class="card">
        <div class="card-body">
            {!! $information->content !!}
        </div>
    </div>
</div>
@endsection
