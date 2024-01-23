@extends('layouts.guest')

@section('content')
<div class="row">
    <div class="col-sm-7 d-sm-flex flex-column align-items-center justify-content-between d-none bg-app-dark position-absolute top-0 bottom-0">
        <div class="my-auto login-page">
            <h2 class="fw-bold"><a href="{{ route('welcome') }}" class="text-decoration-none text-light">Penerangan Perkotaan dan Pemakamam Umum</a></h2>
            <p>Dinas Perumahan Rakyat dan Kawasan Pemukiman Kota Gorontalo</p>
        </div>
        <img src="{{ asset('storage/5397657.png') }}" alt="hero" class="img-auth">
    </div>
    <div class="col-sm-5 end-0 d-flex align-items-center justify-content-center position-absolute top-0 bottom-0">
        <div class="box">
            <span class="border-line"></span>
            <form method="POST" action="{{ route('login') }}">
                <h2>Login</h2>
                @csrf
                <div class="input-box">
                    <input id="username" type="text" class="auth-input" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                    <span>username</span>
                    <i></i>
                </div>
                @error('username')
                    <span class="text-danger" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <div class="input-box">
                    <input id="password" type="password" class="auth-input" name="password" value="{{ old('password') }}" required autocomplete="password">
                    <span>password</span>
                    <i></i>
                </div>
                <button type="submit">Login</button>
                <a href="{{ route('welcome') }}" class="text-light d-sm-none d-block mt-auto mb-3 text-center"><i class="bi bi-house me-2 fs-6"></i>kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection