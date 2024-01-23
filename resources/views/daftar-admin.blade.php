@extends('layouts.app')
@section('content')
<div class="container mt-nav">
    <div class="row justify-content-center">
        <div class="@if(count($users) > 0) col-md-6 @else d-none @endif">
            @foreach ($users as $user)
                <div class="dash-card-mono p-3 app-text-primary d-flex align-items-center gap-4 mb-3 position-relative">
                    <i class="bi bi-person fs-1"></i>
                    <h6 class="fw-semibold m-0">{{ $user->name }}<i class="bi bi-at ms-2"></i><small>{{ $user->username }}</small><i class="bi bi-circle-fill mx-2 fs-xxs"></i><small>{{ $user->koarmat->name }}</small></h6>
                    <i class="ms-auto cursor-pointer bi bi-three-dots fs-4" data-bs-toggle="collapse" data-bs-target="#btnDelete{{ $loop->iteration }}"></i>
                    <div class="card-action-popup collapse position-absolute top-50 end-3 mt-1" id="btnDelete{{ $loop->iteration }}">
                        <button class="btn btn-white" onclick="document.getElementById('deleteForm' + {{ $loop->iteration }}).submit()"><i class="bi bi-trash me-2"></i> Hapus Admin</button>
                        <form id="deleteForm{{ $loop->iteration }}" action="{{ route('delete.admin', ['id' => $user->id]) }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-6">
            <div class="dash-card-mono p-4">
                <h6 class="fw-bold text-center">Tambahkan Admin Baru</h6>
                <div class="alert alert-secondary" role="alert">
                    @foreach ($allKoarmat as $koarmat => $allKecamatan)
                        @if ($loop->iteration > 1) <br> @endif
                        <h6 class="fw-semibold d-inline">{{ $koarmat . ': ' }}</h6>
                        @foreach ($allKecamatan as $kecamatan)
                            <i>{{ ($loop->iteration > 1 ? ', ' : '') . $kecamatan->kecamatan }}</i>
                        @endforeach
                    @endforeach
                </div>
                <form action="{{ route('add.admin') }}" method="POST">
                    @csrf
                    <div class="row mb-3">
                        <label for="koarmat" class="col-sm-4 form-label">Wilayah Tugas</label>
                        <div class="col-sm-8">
                            <select class="form-select @error('koarmat') is-invalid @enderror" id="koarmat" name="koarmat">
                                <option>Pilih Koarmat</option>
                                @foreach ($allKoarmat as $koarmat => $val)
                                    <option value="{{ $koarmat }}">{{ $koarmat }}</option>
                                @endforeach
                            </select>
                            @error('koarmat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-4 form-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="masukkan nama admin" value="{{ old('nama') }}">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="username" class="col-sm-4 form-label">Username</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="masukkan username" value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-sm-4 form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="masukkan password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="konfirmasi_password" class="col-sm-4 form-label">Konfirmasi Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control @error('konfirmasi_password') is-invalid @enderror" id="konfirmasi_password" name="konfirmasi_password" placeholder="masukkan konfirmasi password">
                            @error('konfirmasi_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8 offset-sm-4">
                            <button class="btn btn-app-primary rounded-pill px-4" type="submit">Simpan Admin</button>
                        </div>
                    </div>
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