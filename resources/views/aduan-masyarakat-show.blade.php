@extends('layouts.app')
@section('content')
    <div class="container mt-nav">
        <div class="row mt-5 justify-content-center">
            <div class="col-12">
                <div class="dash-card-mono p-4">
                    <div class="d-flex align-items-start mb-4">
                        <div>
                            <p class="m-0">Nama Pengadu</p>
                            <h6 class="fw-bold mb-3">{{ $pengaduan->nama_pengadu }}</h6>
                            <p class="m-0">Nomor Telepon</p>
                            <h6 class="fw-bold mb-3">{{ $pengaduan->no_telepon_pengadu }}</h6>
                            <p class="m-0">Alamat</p>
                            <h6 class="fw-bold mb-3">{{ $pengaduan->alamat_pengadu }}</h6>
                            <p class="m-0">Wilayah</p>
                            <h6 class="fw-bold">{{ $pengaduan->wilayah->kelurahan . ', ' . $pengaduan->wilayah->kecamatan }}</h6>
                        </div>
                        @if ($pengaduan->ket == App\Helper\StatusPemeliharaan::BELUM_DIPROSES)
                            <a href="{{ route('aduan.masyarakat.create', ['aduan' => $pengaduan->id]) }}" class="btn btn-app-primary ms-auto">Proses pengaduan</a>
                        @endif
                    </div>
                    @if(count($pengaduan->gambar) > 0)
                    <div class="d-flex justify-content-center mb-4">
                        <img src="{{ asset('storage/pengaduan/' . $pengaduan->gambar[0]->name) }}" alt="none" class="preview-img-wide">
                    </div>
                    @endif
                    <div class="mb-4">
                        <div id="map" style="width: 100%; height: 400px;"></div>
                        <a target="sites" href="{{ route('aduan.masyarakat.open', ['latitude' => $pengaduan->latitude, 'longitude' => $pengaduan->longitude]) }}" class="btn btn-primary mt-3">Buka di google maps</a>
                    </div>
                    <a href="{{ route('aduan.masyarakat.delete', ['aduan' => $pengaduan->id]) }}" class="btn btn-danger w-100">Hapus</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([@json($pengaduan->latitude), @json($pengaduan->longitude)], 10)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map)

        var marker = L.marker([@json($pengaduan->latitude), @json($pengaduan->longitude)]).addTo(map);
    </script>
@endpush