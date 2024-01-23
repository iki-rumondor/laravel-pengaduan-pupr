@extends('layouts.guest')
@section('content')
    <div class="container welcome-page">
        <div class="row justify-content-center">
            <div class="col-sm-6 d-flex flex-column align-items-center">
                <img src="{{ asset('storage/logo-gorontalokota.png') }}" alt="gorontalokota" class="mb-4">
                <h1 class="text-center fw-semibold">Dinas Perumahan Rakyat dan Kawasan Pemukiman Kota Gorontalo</h1>
                <h6 class="mt-4 text-center">Penerangan Perkotaan dan Pemakamam Umum</h6>
                <div class="d-flex mt-4 align-items-center gap-3">
                    <a href="{{ route('masyarakat.create.pengaduan') }}" class="btn btn-app-primary rounded-0 py-2">Buat Aduan</a>
                    <a href="{{ route('login') }}" class="btn btn-app-primary-light px-4 py-2 rounded-0">Login</a>
                </div>
                <p class="mt-5">Bagikan website :</p>
                <div class="d-flex align-items-center justify-content-center gap-3">
                    <a href="{{ route('share.app', ['provider' => 'facebook']) }}" target="sites" class="p-4 rounded-circle bg-primary position-relative text-decoration-none text-white">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="bi bi-facebook fs-3"></i>
                        </div>
                    </a>
                    <a href="{{ route('share.app', ['provider' => 'whatsapp']) }}" target="sites" class="p-4 rounded-circle bg-success position-relative text-decoration-none text-white">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="bi bi-whatsapp fs-3"></i>
                        </div>
                    </a>
                    <a href="{{ route('share.app', ['provider' => 'twitter']) }}" target="sites" class="p-4 rounded-circle bg-primary position-relative text-decoration-none text-white">
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="bi bi-twitter fs-3"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection