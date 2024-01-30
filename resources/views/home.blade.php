@extends('layouts.app')
@section('content')
    <div class="container mt-nav">
        <h3 class="fw-semibold mb-4">Selamat datang {{ auth()->user()->username }} <i class="bi bi-emoji-smile ms-2"></i></h3>
        <div class="dash-card-mono">
            {{-- @if ($show_grafik)
            {!! $chart->container() !!}
        @else
            <div class="d-flex align-items-center justify-content-center flex-column p-5">
                <p class="text-center">Tetaplah di sini untuk mengelola dan menangani semua pengaduan yang masuk dengan cepat dan efisien melalui dashboard sistem pengaduan ini. Selamat datang, Admin!</p>
                <a href="{{ route('create.pengaduan') }}" class="btn btn-app-primary mt-4">Buat pengaduan</a>
            </div>
        @endif
         --}}
         <div class="row">
             <canvas id="aduanChart"></canvas>
         </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }} --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('aduanChart');

        const labels = {!! $labels !!};

        const data = {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pengaduan 5 Bulan Terakhir',
                data: {!! $values !!},
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };

        const config = {
            type: 'line',
            data: data,
        };

        new Chart(ctx, config)
    </script>
@endpush
