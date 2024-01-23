@extends('layouts.guest')

@section('content')
<div class="container position-absolute top-50 start-50 translate-middle">
    <div class="image-bg-container">
        <img src="{{ asset('storage/5397657.png') }}" alt="hero" class="image-bg-blur-sm">
    </div>
    <div class="box mx-auto">
        <span class="border-line"></span>
        <form method="POST" action="{{ route('login') }}">
            <h2>Login</h2>
            @csrf
            <div class="input-box">
                <input id="username" type="text" class="auth-input" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                <span>username</span>
                <i></i>
                @error('username')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-box">
                <input id="password" type="password" class="auth-input" name="password" value="{{ old('password') }}" required autocomplete="password">
                <span>password</span>
                <i></i>
                @error('password')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</div>
@endsection