@extends('layouts.app')
@section('content')
<div class="container mt-nav">
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <div class="dash-card-mono p-4">
                <h6 class="fw-bold text-center mb-3">Profil</h6>
                <form action="{{ route('profil.update.username') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') ? old('username') : auth()->user()->username }}" placeholder="masukkan username">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-app-primary rounded-pill" type="submit">Update Username</button>
                </form>
                <h6 class="fw-semibold mt-4">Ubah Password</h6>
                <form action="{{ route('profil.update.password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="password_sekarang" class="form-label">Password Sekarang</label>
                        <input type="password" name="password_sekarang" id="password_sekarang" class="form-control @error('password_sekarang') is-invalid @enderror" placeholder="masukkan password sekarang">
                        @error('password_sekarang')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_baru" class="form-label">Password Baru</label>
                        <input type="password" name="password_baru" id="password_baru" class="form-control @error('password_baru') is-invalid @enderror" placeholder="masukkan password baru">
                        @error('password_baru')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="konfirmasi_password_baru" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" name="konfirmasi_password_baru" id="konfirmasi_password_baru" class="form-control @error('konfirmasi_password_baru') is-invalid @enderror" placeholder="masukkan konfirmasi password baru">
                        @error('konfirmasi_password_baru')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn btn-app-primary rounded-pill" type="submit">Update Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script>
        window.addEventListener('load', function() {
            @if(session()->has('success'))
                Swal.fire({
                    title: "Sukses",
                    text: @json(session('success')),
                    icon: "success"
                })
            @endif
        })
    </script>
@endpush