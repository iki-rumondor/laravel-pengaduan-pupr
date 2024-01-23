@extends('layouts.app')
@section('content')
    <div class="container mt-nav">
        <div class="row mt-5 justify-content-center">
            <div class="col-12">
                @foreach ($allPengaduan as $pengaduan)
                    <a href="{{ route('aduan.masyarakat.show', ['aduan' => $pengaduan->id]) }}" class="dash-card w-100 d-flex text-decoration-none text-white mb-3 p-4">
                        @if($pengaduan->kategori == 'perawatan')
                            <i class="bi bi-house-heart fs-1"></i>
                        @elseif($pengaduan->kategori == 'buat_baru')
                            <i class="bi bi-node-plus-fill fs-1"></i>
                        @endif
                        <div>
                            <h6 class="fw-semibold m-0 d-inline">{{ $pengaduan->nama_pengadu }}</h6>
                            <p class="m-0 d-inline-block ms-2">{{ $pengaduan->wilayah->kelurahan . ', ' . $pengaduan->wilayah->kecamatan }}</p>
                            <div class="d-flex gap-2 mt-2">
                                <p class="m-0 badge bg-app-primary text-light rounded-pill" style="text-transform: capitalize">{{ str_replace('_', ' ', $pengaduan->kategori) }}</p>
                                <p class="m-0 badge {{ $pengaduan->ket == App\Helper\StatusPemeliharaan::BELUM_DIPROSES ? 'bg-warning text-dark' : ($pengaduan->ket == App\Helper\StatusPemeliharaan::SEMENTARA_DIPROSES ? 'bg-primary text-white' : ($pengaduan->ket == App\Helper\StatusPemeliharaan::SUDAH_DIPROSES ? 'bg-success text-white' : '')) }} rounded-pill">{{ $pengaduan->ket }}</p>
                            </div>
                        </div>
                        <small class="ms-auto">{{ $pengaduan->created_at->diffForHumans() }}</small>
                    </a>
                @endforeach
                <div>
                    {{ $allPengaduan->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection