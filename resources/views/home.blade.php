@extends('layouts.app')
@section('content')
<div class="container mt-nav">
    <h3 class="fw-semibold mb-4">Selamat datang {{ auth()->user()->username}} <i class="bi bi-emoji-smile ms-2"></i></h3>
    <div class="dash-card-mono">
        @if($show_grafik)
            {!! $chart->container() !!}
        @else
            <div class="d-flex align-items-center justify-content-center flex-column p-5">
                <p class="text-center">Tetaplah di sini untuk mengelola dan menangani semua pengaduan yang masuk dengan cepat dan efisien melalui dashboard sistem pengaduan ini. Selamat datang, Admin!</p>
                <a href="{{ route('create.pengaduan') }}" class="btn btn-app-primary mt-4">Buat pengaduan</a>
            </div>
        @endif
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
@endpush