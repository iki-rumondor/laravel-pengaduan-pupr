@extends('layouts.app')
@section('content')
<div class="container mt-nav">
    <div class="row mt-5 justify-content-center">
        <div class="col-md-10">
            <div class="dash-card-mono p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="fw-semibold mb-4 m-0">Buat Pengaduan</h6>
                    <a href="{{ route('index.pengaduan') }}" class="btn btn-app-primary">Lihat semua pengaduan</a>
                </div> 
                <form action="{{ route('save.pengaduan') }}" method="POST" class="opacity-100">
                    @csrf
                    <div class="row mb-3">
                        <label for="nama_pengadu" class="col-sm-4 form-label">Nama Pengadu</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control @error('nama_pengadu') is-invalid @enderror" id="nama_pengadu" name="nama_pengadu" value="{{ old('nama_pengadu') }}" placeholder="gilfoyle" autofocus>
                            @error('nama_pengadu')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="alamat_pengadu" class="col-sm-4 form-label">Alamat Pengadu</label>
                        <div class="col-sm-8">
                            <textarea rows="2" class="form-control @error('alamat_pengadu') is-invalid @enderror" id="alamat_pengadu" name="alamat_pengadu" value="{{ old('alamat_pengadu') }}"></textarea>
                            @error('alamat_pengadu')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="wilayah" class="col-sm-4 form-label">Wilayah Pengaduan</label>
                        <div class="col-sm-8">
                            <select class="form-select @error('wilayah') is-invalid @enderror" id="wilayah" name="wilayah" value="{{ old('wilayah') }}">
                                <option>wilayah</option>
                                @foreach ($wilayah as $op)
                                    <option value="{{ $op->id }}">{{ $op->kelurahan . ', ' . $op->kecamatan }}</option>
                                @endforeach
                            </select>
                            @error('wilayah')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="no_telepon_pengadu" class="col-sm-4 form-label">No Telepon Pengadu</label>
                        <div class="col-sm-8">
                            <input type="text" inputmode="tel" class="form-control @error('no_telepon_pengadu') is-invalid @enderror" id="no_telepon_pengadu" name="no_telepon_pengadu" value="{{ old('no_telepon_pengadu') }}" placeholder="081483*****">
                            @error('no_telepon_pengadu')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="kategori" class="col-sm-4 form-label">Kategori Pengaduan</label>
                        <div class="col-sm-8">
                            <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori" value="{{ old('kategori') }}">
                                <option>Kategori</option>
                                <option value="pemeliharaan">Pemeliharaan</option>
                                <option value="pasang_baru">Pasang Baru</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="dasar_pemeliharaan" class="col-sm-4 form-label">Dasar Pemeliharaan</label>
                        <div class="col-sm-8">
                            <select class="form-select @error('dasar_pemeliharaan') is-invalid @enderror" id="dasar_pemeliharaan" name="dasar_pemeliharaan" value="{{ old('dasar_pemeliharaan') }}">   
                                <option>Pilih Dasar Pemeliharaan</option>
                                <option value="{{ App\Helper\Pemeliharaan::MONITORING }}">{{ App\Helper\Pemeliharaan::MONITORING }}</option>
                                <option value="{{ App\Helper\Pemeliharaan::ADUAN }}">{{ App\Helper\Pemeliharaan::ADUAN }}</option>
                            </select>
                            @error('dasar_pemeliharaan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="jenis" class="col-sm-4 form-label">Jenis</label>
                        <div class="col-sm-8">
                            <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" value="{{ old('jenis') }}">   
                                <option>Pilih Jenis</option>
                                <option value="{{ App\Helper\JenisPemeliharaan::JARINGAN }}">{{ App\Helper\JenisPemeliharaan::JARINGAN }}</option>
                                <option value="{{ App\Helper\JenisPemeliharaan::MANUAL }}">{{ App\Helper\JenisPemeliharaan::MANUAL }}</option>
                            </select>
                            @error('jenis')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="material" class="col-sm-4 form-label">Material</label>
                        <div class="col-sm-8">
                            @foreach ($allMaterial as $material)
                                <div class="d-flex gap-3 align-items-center justify-content-between mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" @if($material->stok == 0) disabled @endif id="{{ $material->name }}" name="material[{{ $material->id }}]" class="form-check-input" {{ old('material.'.$material->id) ? 'checked' : '' }}>
                                        <label for="{{ $material->name }}" class="form-check-label">{{ $material->name }}</label>
                                    </div>
                                    @if ($material->stok == 0)
                                        <i>Stok habis</i>
                                    @else
                                        <span>stok : {{ $material->stok }}</span>
                                        <div>
                                            <div class="d-flex gap-2 align-items-center" style="width: 50%">
                                                <input type="number" id="jumlah{{ $material->id }}" name="jumlah[{{ $material->id }}]" class="form-control form-control-sm" placeholder="jumlah">
                                                <label for="jumlah{{ $material->id }}" class="form-label m-0">Buah</label>
                                            </div>
                                            @error('jumlah_' . $material->id)
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            @error('material')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8 offset-sm-4">
                            <button class="btn btn-app-primary rounded-pill px-5" type="submit">Simpan</button>
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
            @elseif(session()->has('failure'))
                Swal.fire({
                    title: "Gagal",
                    text: @json(session('failure')),
                    icon: "error"
                })
            @endif
        })
    </script>
@endpush