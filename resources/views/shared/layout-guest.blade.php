@extends('shared.layout-base')

@section('extra-head')
    <link rel="stylesheet" href="{{ asset('css/app-guest.css') }}">
@endsection

@section('body')
    @include('shared.navbar-guest')

    <div style="min-height: 80vh">
        @yield('content')
    </div>

    <footer class="py-5 bg-default">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; 2019 Virtual Tour Wisata Kabupaten Kapuas Hulu</p>
        </div>
    </footer>
@endsection
