<div class="row">
    @if ($isShowDetail || $fromOther)
        <div class="col-sm-2 mb-4">
            <button class="btn btn-dark px-4 rounded-pill" @if($fromOther) wire:click='backToShowAll' @else wire:click='showAll' @endif><i class="bi bi-arrow-left me-2"></i>Lihat semua</button>
        </div>
        <div class="col-12">
            <div class="dash-card-mono p-4">
                <div class="row mb-3">
                    <div class="col-sm-3">Tanggal</div>
                    <div class="col-sm-9">{{$selectedPengaduan->created_at->translatedFormat('d F Y')}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">Nama Pengadu</div>
                    <div class="col-sm-9">{{$selectedPengaduan->nama_pengadu}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">Alamat Pengadu</div>
                    <div class="col-sm-9">{{$selectedPengaduan->alamat_pengadu}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">Wilayah Aduan</div>
                    <div class="col-sm-9">{{'Kelurahan ' . $selectedPengaduan->wilayah->kelurahan . ', Kecamatan ' . $selectedPengaduan->wilayah->kecamatan}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">Nomor Telepon Pengadu</div>
                    <div class="col-sm-9">{{$selectedPengaduan->no_telepon_pengadu}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">Kategori</div>
                    <div class="col-sm-9" style="text-transform: capitalize">{{str_replace('_', ' ', $selectedPengaduan->kategori)}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">Dasar Pemeliharaan</div>
                    <div class="col-sm-9">{{$selectedPengaduan->dasar_pemeliharaan}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">Material</div>
                    <div class="col-sm-9">
                        @foreach ($selectedPengaduan->material()->withPivot('jumlah')->get() as $material)
                            <span>{{ ($loop->iteration > 1 ? ', ' : '') . $material->pivot->jumlah . ' buah ' . $material->name }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">Jenis</div>
                    <div class="col-sm-9">{{$selectedPengaduan->jenis}}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-3">Ket</div>
                    <div class="col-sm-9"><h5 class="m-0 badge {{ $selectedPengaduan->ket == App\Helper\StatusPemeliharaan::BELUM_DIPROSES ? 'bg-warning text-dark' : ($selectedPengaduan->ket == App\Helper\StatusPemeliharaan::SEMENTARA_DIPROSES ? 'bg-primary text-white' : ($selectedPengaduan->ket == App\Helper\StatusPemeliharaan::SUDAH_DIPROSES ? 'bg-success text-white' : '')) }} rounded-pill">{{ $selectedPengaduan->ket }}</h5></div>
                </div>
                <h6 class="fw-semibold mt-5 mb-3">Update status pengaduan</h6>
                <button class="btn btn-primary rounded-pill px-4" type="button" wire:click=prosesAduan><i class="bi bi-hourglass-split me-2"></i>Pengaduan di proses</button>
                <button class="btn btn-success rounded-pill px-4 ms-2" type="button" wire:click='selesaiAduan'><i class="bi bi-check2-circle me-2"></i>Pengaduan selesai</button>
                <button class="btn btn-danger rounded-pill px-4 ms-2" type="button" wire:click='hapusAduan'><i class="bi bi-trash me-2"></i>Hapus pengaduan</button>
                <h6 class="fw-semibold mt-5">Tambahkan gambar</h6>
                <label for="gambar" class="dash-card-mono card-sm px-5 py-3 card-grey cursor-pointer">
                    <i class="bi bi-plus-square-dotted fs-1"></i>
                </label>
                <input type="file" id="gambar" name="gambar" wire:model.live='gambar' hidden>
                @if (count($selectedPengaduan->gambar) > 0)
                    <div class="d-flex flex-wrap align-items-center gap-3 mt-4">
                        @foreach ($selectedPengaduan->gambar as $gambar)
                            <div class="card-image" wire:click="previewImage('{{ $gambar->name }}')">
                                <img src="{{ asset('storage/pengaduan/' . $gambar->name) }}" alt="none">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="image-preview {{ !$previewImageName ? 'd-none' : '' }}">
            <i class="bi bi-x" wire:click='closePreview' style="filter: drop-shadow(0 0 20px rgba(0, 0, 0, 0.801));"></i>
            <img src="{{ asset('storage/pengaduan/' . $previewImageName) }}" alt="none">
        </div>
        <div wire:loading wire:target='gambar,backToShowAll'>
            <div class="main-loading-fixed-container d-flex align-items-center justify-content-center">
                <div class="spinner-border text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    @endif
    <div class="col-12 mb-3 {{ $isShowDetail || $fromOther ? 'd-none' : '' }}">
        <div class="dash-card-mono p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center">
                <h6 class="fw-semibold m-0">Semua Pengaduan</h6>
                <a href="{{ route('create.pengaduan') }}" class="btn btn-app-primary"><i class="bi bi-plus-circle-fill me-2"></i>Buat pengaduan baru</a>
            </div>
            <div class="row my-3">
                <div class="col-sm-6">
                    <input wire:model.live='search' type="search" class="form-control" id="search" name="search" placeholder="cari wilayah atau pengadu">
                </div>
                <div class="col-sm-3">
                    <select name="kecamatan" id="kecamatan" class="form-select" wire:model.live='search'>
                        <option>Kecamatan</option>
                        @foreach ($allKecamatan as $kecamatan)
                            <option value="{{ $kecamatan->kecamatan }}">{{ $kecamatan->kecamatan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <select name="kelurahan" id="kelurahan" class="form-select" wire:model.live='search'>
                        <option>Kelurahan</option>
                        @foreach ($allKelurahan as $kelurahan)
                            <option value="{{ $kelurahan->kelurahan }}">{{ $kelurahan->kelurahan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    @if (count($allPengaduan))
        @foreach ($allPengaduan as $pengaduan)
            <div class="col-md-4 col-sm-6 mb-3 d-flex align-items-stretch {{ $isShowDetail || $fromOther ? 'd-none' : '' }}">
                <div class="dash-card shadow-app-primary p-3 d-flex align-items-center gap-3 w-100" wire:click="showDetail({{ $pengaduan->id }})">
                    @if($pengaduan->kategori == 'perawatan')
                        <i class="bi bi-house-heart fs-1"></i>
                    @elseif($pengaduan->kategori == 'buat_baru')
                        <i class="bi bi-node-plus-fill fs-1"></i>
                    @endif
                    <div>
                        <h6 class="fw-semibold m-0">{{ $pengaduan->nama_pengadu }}</h6>
                        <p class="m-0">{{ $pengaduan->wilayah->kelurahan . ', ' . $pengaduan->wilayah->kecamatan }}</p>
                        <div class="d-flex gap-2 mt-2">
                            <p class="m-0 badge bg-app-primary text-light rounded-pill" style="text-transform: capitalize">{{ str_replace('_', ' ', $pengaduan->kategori) }}</p>
                            <p class="m-0 badge {{ $pengaduan->ket == App\Helper\StatusPemeliharaan::BELUM_DIPROSES ? 'bg-warning text-dark' : ($pengaduan->ket == App\Helper\StatusPemeliharaan::SEMENTARA_DIPROSES ? 'bg-primary text-white' : ($pengaduan->ket == App\Helper\StatusPemeliharaan::SUDAH_DIPROSES ? 'bg-success text-white' : '')) }} rounded-pill">{{ $pengaduan->ket }}</p>
                        </div>
                    </div>
                    <small class="ms-auto">{{ $pengaduan->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @endforeach
        <div class="{{ $isShowDetail || $fromOther ? 'd-none' : '' }}">
            {{ $allPengaduan->links() }}
        </div>
        @else
        <div class="col-12 {{ $isShowDetail ? 'd-none' : '' }}">
            <div class="dash-card-mono text-center p-4">
                Tidak ada pengaduan
            </div>
        </div>
    @endif
</div>