@extends('layouts.guest')
@section('content')
    <div class="container-fluid {{ session()->has('success') ? 'position-absolute top-50 start-50 translate-middle' : '' }}">
        <div class="row justify-content-center">
            <div class="col-sm-10">
                <div class="dash-card-mono p-sm-5">
                    @if (session()->has('success'))
                        <div class="d-flex flex-column align-items-center justify-content-center py-5">
                            <i class="bi bi-check-circle fs-1 text-success mb-4"></i>
                            <h6>{{ session('success') }}</h6>
                            <a href="{{ route('welcome') }}" class="app-text-primary"><i
                                    class="bi bi-arrow-left me-2"></i>Kembali</a>
                        </div>
                    @elseif(session()->has('failure'))
                        <div class="d-flex flex-column align-items-center justify-content-center py-5">
                            <i class="bi bi-x-circle fs-1 text-danger mb-4"></i>
                            <h6>{{ session('failure') }}</h6>
                            <a href="{{ route('welcome') }}" class="app-text-primary"><i
                                    class="bi bi-arrow-left me-2"></i>Kembali</a>
                        </div>
                    @else
                        <h4 class="fw-semibold mb-4 text-center">Buat Pengaduan</h4>
                        <form id="formSubmit" action="{{ route('masyarakat.store.pengaduan') }}" method="POST"
                            class="opacity-100" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="latitude" name="latitude">
                            <input type="hidden" id="longitude" name="longitude">
                            <div class="row mb-3">
                                <label for="nama_pengadu" class="col-sm-4 form-label">Nama Pengadu</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control @error('nama_pengadu') is-invalid @enderror"
                                        id="nama_pengadu" name="nama_pengadu" value="{{ old('nama_pengadu') }}"
                                        placeholder="gilfoyle" autofocus>
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
                                    <textarea rows="2" class="form-control @error('alamat_pengadu') is-invalid @enderror" id="alamat_pengadu"
                                        name="alamat_pengadu" value="{{ old('alamat_pengadu') }}"></textarea>
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
                                    <select class="form-select @error('wilayah') is-invalid @enderror" id="wilayah"
                                        name="wilayah" value="{{ old('wilayah') }}">
                                        <option>wilayah</option>
                                        @foreach ($wilayah as $op)
                                            <option value="{{ $op->id }}">
                                                {{ $op->kelurahan . ', ' . $op->kecamatan }}</option>
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
                                    <input type="text" inputmode="tel"
                                        class="form-control @error('no_telepon_pengadu') is-invalid @enderror"
                                        id="no_telepon_pengadu" name="no_telepon_pengadu"
                                        value="{{ old('no_telepon_pengadu') }}" placeholder="081483*****">
                                    @error('no_telepon_pengadu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="bukti_pendukung" class="col-sm-4 form-label">Bukti Pendukung</label>
                                <div class="col-sm-8">
                                    <input type="file"
                                        class="form-control @error('bukti_pendukung') is-invalid @enderror"
                                        id="bukti_pendukung" name="bukti_pendukung" value="{{ old('bukti_pendukung') }}">
                                    <small class="fst-italic"><i class="bi bi-info-circle me-2"></i>sertakan foto</small>
                                    @error('bukti_pendukung')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="mb-3">
                                <h6 class="fw-semibold">Tambahkan titik lokasi</h6>
                                <div id="map" style="width: 100%; height: 400px;"></div>
                                <input type="text" id="latitude" name="latitude" hidden>
                                <input type="text" id="longitude" name="longitude" hidden>
                                @error('titik_lokasi')
                                    <div class="text-danger mt-3">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}
                            <div class="row">
                                <div class="col-sm-8 offset-sm-4">
                                    <button id="btnSubmit" class="btn btn-app-primary rounded-pill px-5"
                                        type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    {{-- <script>
        var map = L.map('map').setView([0.5350714631502665, 123.0597496032715], 10);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map)
        var marker
        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker)
            }
            marker = L.marker(e.latlng).addTo(map)
            var latitude = e.latlng.lat
            var longitude = e.latlng.lng
            document.getElementById('latitude').value = latitude
            document.getElementById('longitude').value = longitude
        });
    </script> --}}
    <script>
        const handleSuccess = (position) => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            $("#latitude").val(latitude)
            $("#longitude").val(longitude)
            $("#formSubmit").submit()
        }

        const handleError = (error) => {
            alert(error.message)
        }

        $(document).ready(function() {
            if (!navigator.geolocation) {
                return console.log("Geolocation tidak support untuk web browser ini")
            }

            $("#btnSubmit").click(function(e) {
                e.preventDefault();
                navigator.geolocation.getCurrentPosition(handleSuccess, handleError)
            })
        })
    </script>
@endpush
