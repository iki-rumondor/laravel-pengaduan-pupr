<div class="container mt-nav">
    @if ($showDetail)
        @livewire('pengaduan', ['selectedPengaduan' => $selectedPengaduan, 'fromOther' => true])
    @else
        <h6 class="fw-bold mb-3">Rekapan Pengaduan</h6>
        <div class="d-flex gap-3 justify-content-sm-between mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="--bs-breadcrumb-divider-color: white">
                    @if($selectedMonth)
                        <li class="breadcrumb-item {{ !$selectedKecamatan && !$selectedKelurahan ? 'active' : '' }}" wire:click='toMonth' style="--bs-breadcrumb-item-active-color: #white">
                            <a onclick="event.preventDefault()" class="text-white" href="{{ route('rekap.pengaduan', ['bulan' => $selectedMonth]) }}">{{ $selectedMonth }}</a>
                        </li>
                    @endif
                    @if($selectedKecamatan)
                        <li class="breadcrumb-item {{ !$selectedKelurahan ? 'active' : '' }}" wire:click='toKecamatan' style="--bs-breadcrumb-item-active-color: #white">
                            <a onclick="event.preventDefault()" class="text-white" href="{{ route('rekap.pengaduan', ['bulan' => $selectedMonth, 'kecamatan' => $selectedKecamatan]) }}">{{ $selectedKecamatan }}</a>
                        </li>
                    @endif
                    @if($selectedKelurahan)
                        <li class="breadcrumb-item active" aria-current="page" style="--bs-breadcrumb-item-active-color: #white" wire:click='toKelurahan'>
                            <a onclick="event.preventDefault()" class="text-white" href="{{ route('rekap.pengaduan', ['bulan' => $selectedMonth, 'kecamatan' => $selectedKecamatan, 'kelurahan' => $selectedKelurahan]) }}">{{ $selectedKelurahan }}</a>
                        </li>
                    @endif
                </ol>
            </nav>
            @if ($selectedMonth && $selectedKecamatan && !$selectedKelurahan)
                <div>
                    <button class="btn btn-dark rounded-0 border {{ !$isShowPengaduanInKec ? 'active' : '' }}" wire:click='showPengaduanInKec(false)'>Kelurahan</button>
                    <button class="btn btn-dark rounded-0 border ms-n2 {{ $isShowPengaduanInKec ? 'active' : '' }}" wire:click='showPengaduanInKec(true)'>Pengaduan</button>
                </div>
            @endif
        </div>
        @if(($selectedMonth && $selectedKecamatan && $selectedKelurahan) || $isShowPengaduanInKec)
            <div class="dash-card-mono p-4">
                <div class="d-flex flex-wrap gap-3 justify-content-sm-between">
                    <h5 class="fw-bold m-0">{{ $selectedMonth }}</h5>
                    <button class="btn btn-white" wire:click='downloadExcel'><i class="bi bi-download me-2"></i>Download Excel</button>
                </div>
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Dasar Pemeliharaan</th>
                            <th scope="col">Material</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Ket</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allPerMonth as $pengaduan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ date('d M Y', $pengaduan->created_at->timestamp) }}</td>
                                <td>{{ $pengaduan->alamat_pengadu . ', ' . $pengaduan->wilayah->kelurahan . ', ' . $pengaduan->wilayah->kecamatan }}</td>
                                <td>{{ $pengaduan->dasar_pemeliharaan }}</td>
                                <td>
                                    @foreach ($pengaduan->material()->withPivot('jumlah')->get() as $material)
                                        <span>{{ ($loop->iteration > 1 ? ', ' : '') . $material->pivot->jumlah . ' buah ' . $material->name }}</span>
                                    @endforeach    
                                </td>
                                <td>{{ $pengaduan->jenis }}</td>
                                <td class="{{ $pengaduan->ket == App\Helper\StatusPemeliharaan::BELUM_DIPROSES ? 'text-warning' : ($pengaduan->ket == App\Helper\StatusPemeliharaan::SEMENTARA_DIPROSES ? 'text-primary' : ($pengaduan->ket == App\Helper\StatusPemeliharaan::SUDAH_DIPROSES ? 'text-success' : '')) }}">{{ $pengaduan->ket }}</td>
                                <td>
                                    <i class="bi bi-box-arrow-in-up-right cursor-pointer fs-4" wire:click='showPengaduanDetail({{ $pengaduan->id }})'></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @elseif($selectedMonth && $selectedKecamatan)
            <div class="d-flex flex-wrap align-items-center gap-4">
                @foreach ($allKelurahanByKecamatan as $kelurahan => $pengaduanKel)
                    <div class="dash-card-mono d-flex flex-column align-items-center justify-content-center card-sm py-2 px-4 cursor-pointer shadow-app-primary" wire:click="selectKelurahan('{{ $kelurahan }}')">
                        <i class="bi bi-folder-fill fs-large text-center position-relative">
                            <span class="position-absolute top-50 start-50 translate-middle text-dark fst-normal fs-5 fs-bold">{{ count($pengaduanKel) }}</span>
                        </i>
                        <span>{{ $kelurahan }}</span>
                    </div>
                @endforeach
            </div>
        @elseif($selectedMonth)
            <div class="d-flex flex-wrap align-items-center gap-4">
                @foreach ($allKecamatan as $kecamatan => $pengaduanKec)
                    <div class="dash-card-mono d-flex flex-column align-items-center justify-content-center card-sm py-2 px-4 cursor-pointer shadow-app-primary" wire:click="selectKecamatan('{{ $kecamatan }}')">
                        <i class="bi bi-folder-fill fs-large text-center position-relative">
                            <span class="position-absolute top-50 start-50 translate-middle text-dark fst-normal fs-5">{{ count($pengaduanKec) }}</span>
                        </i>
                        <span>{{ $kecamatan }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="d-flex flex-wrap align-items-center gap-4">
                @foreach ($allMonth as $month)
                    <div class="dash-card-mono d-flex flex-column align-items-center justify-content-center card-sm py-2 px-5 cursor-pointer shadow-app-primary" wire:click="selectMonth('{{ $month->bulan }}')">
                        <i class="bi bi-folder-fill fs-large text-center position-relative">
                            <span class="position-absolute top-50 start-50 translate-middle text-dark fst-normal fs-5 fw-bold">{{ $month->jumlah_data }}</span>
                        </i>
                        <span>{{ $month->bulan }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
    <div wire:loading wire:target='showPengaduanDetail,backToShowAll'>
        <div class="main-loading-fixed-container d-flex align-items-center justify-content-center">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>
</div>