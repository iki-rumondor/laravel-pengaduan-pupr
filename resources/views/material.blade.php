@extends('layouts.app')
@section('content')
<div class="container mt-nav">
    <div class="row justify-content-center">
        <div class="col-sm-10">
            <div class="dash-card-mono p-4">
                <button class="btn btn-app-primary w-100 mb-4" data-bs-toggle="modal" data-bs-target="#addMaterialModal">Tambah Material</button>
                <table class="table table-striped table-dark">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Material</th>
                            <th scope="col">Stok</th>
                            <th scope="col" style="width: 25%">Aksi</th>
                            <th scope="col" style="width: 25%">Ket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($allMaterial) > 0)
                            @foreach ($allMaterial as $material)
                                <tr class="text-center">
                                    <td>{{ $material->name }}</td>
                                    <td>{{ $material->stok }}</td>
                                    <td>
                                        <button id="btnEditStok" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editStokModal" data-material-id="{{ $material->id }}" data-material-stok="{{ $material->stok }}" data-material-name="{{ $material->name }}"><i class="bi bi-pencil"></i></button>
                                        <button id="btnDeleteMaterial" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#deleteMaterialModal" data-material-id="{{ $material->id }}" data-material-name="{{ $material->name }}"><i class="bi bi-trash"></i></button>
                                    </td>
                                    <td>{{ $material->created_at == $material->updated_at ? 'Dibuat ' . $material->created_at->diffForHumans() : 'Diupdate ' . $material->updated_at->diffForHumans() }}</td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="4" class="text-center">Tidak ada material</td>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" style="--bs-modal-bg: #212529;" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addMaterialModalLabel">Tambah Material</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('add.material.pengaduan') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="masukkan nama material">
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" placeholder="masukkan stok material">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-app-primary rounded-pill">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" style="--bs-modal-bg: #212529;" id="editStokModal" tabindex="-1" aria-labelledby="editStokModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editStokModalLabel">Update Stok <span id="materialName"></span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update.stok.material.pengaduan') }}" method="POST">
                    @csrf
                    <input type="text" name="id" hidden id="materialId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editMaterialStok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="editMaterialStok" name="stok" placeholder="masukkan stok material">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-app-primary rounded-pill">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" style="--bs-modal-bg: #212529;" id="deleteMaterialModal" tabindex="-1" aria-labelledby="deleteMaterialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteMaterialModalLabel">Hapus material <span id="deleteMaterialName"></span></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('delete.material.pengaduan') }}" method="POST">
                    @csrf
                    <input type="text" name="id" hidden id="deleteMaterialId">
                    <div class="modal-body">
                        Anda yakin untuk menghapus material ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-app-primary rounded-pill">Ya, Hapus</button>
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
            @elseif($errors->any())
                Swal.fire({
                    title: "Gagal",
                    text: @json($errors->first()),
                    icon: "error"
                })
            @endif

            const btnEdit = document.querySelectorAll('#btnEditStok')
            if (btnEdit) {
                btnEdit.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.dataset.materialId
                        document.getElementById('materialId').value = id
                        const stok = this.dataset.materialStok
                        document.getElementById('editMaterialStok').value = stok
                        const name = this.dataset.materialName
                        document.getElementById('materialName').innerHTML = name
                    })
                });
            }
            const btnDeleteMaterial = document.querySelectorAll('#btnDeleteMaterial')
            if (btnDeleteMaterial) {
                btnDeleteMaterial.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.dataset.materialId
                        document.getElementById('deleteMaterialId').value = id
                        const name = this.dataset.materialName
                        document.getElementById('deleteMaterialName').innerHTML = name
                    })
                });
            }
        })
    </script>
@endpush