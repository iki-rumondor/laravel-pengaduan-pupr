<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Pengaduan;
use App\Models\Wilayah;
use App\Services\PengaduanService;
use Illuminate\Http\Request;

class AduanMasyarakatController extends Controller
{
    private PengaduanService $pengaduanService;

    public function __construct(PengaduanService $pengaduanService)
    {
        $this->middleware('auth');
        $this->pengaduanService = $pengaduanService;
    }

    public function index()
    {
        return response()->view('aduan-masyarakat', [
            'allPengaduan' => auth()->user()->koarmat_id ? $this->pengaduanService->getAllAduanMasyarakatByKoarmat(auth()->user()->koarmat_id) : $this->pengaduanService->getAllAduanMasyarakat()
        ]);
    }

    public function show(Pengaduan $aduan)
    {
        return response()->view('aduan-masyarakat-show', [
            'pengaduan' => $aduan
        ]);
    }

    public function create(Pengaduan $aduan)
    {
        return response()->view('aduan-masyarakat-create', [
            'pengaduan' => $aduan,
            'wilayah' => auth()->user()->koarmat_id !== null ? Wilayah::where('koarmat_id', auth()->user()->koarmat_id)->get() : Wilayah::all(),
            'allMaterial' => Material::where('is_delete', false)->latest()->get()
        ]);
    }

    public function delete(Pengaduan $aduan)
    {
        $aduan->delete();
        return redirect()->route('aduan.masyarakat.index');
    }

    public function openInGoogleMaps($latitude, $longitude)
    {
        $googleMapsUrl = "https://www.google.com/maps?q=$latitude,$longitude";
        return redirect()->away($googleMapsUrl);
    }
}
