@extends('shared.layout')
@section('title', 'Login')
@section('content')
<div class="container my-5">
    <div class="card w-50 m-auto">
        <div class="card-header">
            <i class="fa fa-sign-in"></i>
            Login
        </div>
        <div class="card-body">
            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class='form-group'>
                    <label for='username'> Username: </label>
                
                    <input
                        id='username' name='username' type='text'
                        placeholder='Username'
                        value='{{ old('username') }}'
                        class='form-control {{ !$errors->has('username') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('username') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='password'> Password: </label>
                
                    <input
                        id='password' name='password' type='password'
                        placeholder='Password'
                        value='{{ old('password') }}'
                        class='form-control {{ !$errors->has('password') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('password') }}
                    </div>
                </div>

                <div class="form-group text-right">
                    <button class="btn btn-primary">
                        Log In
                        <i class="fa fa-sign-in"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection