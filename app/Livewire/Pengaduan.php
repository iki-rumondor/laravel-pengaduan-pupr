<?php

namespace App\Livewire;

use App\Helper\StatusPemeliharaan;
use App\Helper\Whatsapp;
use App\Models\Gambar;
use App\Models\Pengaduan as ModelsPengaduan;
use App\Models\Wilayah;
use Illuminate\Validation\Rules\File;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class Pengaduan extends Component
{
    use WithPagination, WithFileUploads;

    private $allPengaduan;
    public $allKecamatan, $allKelurahan, $selectedPengaduan, $isShowDetail, $fromOther;
    public $gambar, $previewImageName;

    public $search, $kategori;

    public function mount()
    {
        $this->search = '';
        $this->kategori = '';
        $this->isShowDetail = false;
    }

    public function updated($field)
    {
        if ($field == 'gambar')
            $this->uploadImage();
    }

    public function render()
    {
        $this->allKecamatan = auth()->user()->koarmat_id !== null ? Wilayah::select('kecamatan', 'created_at')->where('koarmat_id', auth()->user()->koarmat_id)->distinct()->latest()->get() : Wilayah::select('kecamatan', 'created_at')->distinct()->latest()->get();
        $this->allKelurahan = auth()->user()->koarmat_id !== null ? Wilayah::select('kelurahan', 'created_at')->where('koarmat_id', auth()->user()->koarmat_id)->latest()->get() : Wilayah::select('kelurahan', 'created_at')->distinct()->latest()->get();
        $this->getAllPengaduan();
        return view('livewire.pengaduan', [
            'allPengaduan' => $this->allPengaduan
        ]);
    }

    public function showDetail($id)
    {
        $pengaduan = ModelsPengaduan::find($id);
        if ($pengaduan == null)
            return;
        $this->selectedPengaduan = $pengaduan;
        $this->isShowDetail = true;
    }

    public function showAll()
    {
        $this->isShowDetail = false;
        $this->getAllPengaduan();
    }

    public function prosesAduan()
    {
        if ($this->selectedPengaduan !== null) {
            // $phoneNum = Whatsapp::formatNomorHP($this->selectedPengaduan->no_telepon_pengadu);
            // $body = "Pengaduan Anda Pada Dinas Perumahan Rakyat dan Kawasan Pemukiman Kota Gorontalo Sedang Diproses";
            // Whatsapp::sendMessage($phoneNum, $body);
            $this->selectedPengaduan->ket = StatusPemeliharaan::SEMENTARA_DIPROSES;
            $this->selectedPengaduan->save();
        }
    }

    public function selesaiAduan()
    {
        if ($this->selectedPengaduan !== null) {
            // $phoneNum = Whatsapp::formatNomorHP($this->selectedPengaduan->no_telepon_pengadu);
            // $body = "Pengaduan Anda Pada Dinas Perumahan Rakyat dan Kawasan Pemukiman Kota Gorontalo Sudah Selesai Dikerjakan";
            // Whatsapp::sendMessage($phoneNum, $body);
            $this->selectedPengaduan->ket = StatusPemeliharaan::SUDAH_DIPROSES;
            $this->selectedPengaduan->save();
        }
    }

    public function hapusAduan()
    {
        if ($this->selectedPengaduan !== null) {
            $this->selectedPengaduan->delete();
            return redirect()->route('home');
        }
    }

    public function uploadImage()
    {
        if ($this->selectedPengaduan !== null) {
            $this->validate([
                'gambar' => ['required', File::image()]
            ]);
            $imgName = time() . '.jpg';
            $this->gambar->storePubliclyAs('public/pengaduan', $imgName);
            Gambar::create([
                'pengaduan_id' => $this->selectedPengaduan->id,
                'name' => $imgName
            ]);
            $this->selectedPengaduan = ModelsPengaduan::find($this->selectedPengaduan->id);
        }
    }

    public function previewImage($imgName)
    {
        $this->previewImageName = $imgName;
    }

    public function closePreview()
    {
        $this->previewImageName = null;
    }

    public function backToShowAll()
    {
        $this->dispatch('back-to-show-all');
    }

    private function getAllPengaduan()
    {
        $this->allPengaduan = auth()->user()->koarmat_id !== null ? ModelsPengaduan::whereHas('wilayah', function ($wilayah) {
            $wilayah->where('koarmat_id', auth()->user()->koarmat_id);
        })->filters([
            'search' => $this->search,
        ])->latest()->paginate(20) : ModelsPengaduan::filters([
            'search' => $this->search,
        ])->latest()->paginate(20);
    }
}
