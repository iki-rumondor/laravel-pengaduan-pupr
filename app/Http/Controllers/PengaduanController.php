<?php

namespace App\Http\Controllers;

use App\Helper\JenisPemeliharaan;
use App\Helper\Pemeliharaan;
use App\Models\Material;
use App\Models\Pengaduan;
use App\Models\Wilayah;
use App\Services\PengaduanService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PengaduanController extends Controller
{
    private PengaduanService $pengaduanService;

    public function __construct(PengaduanService $pengaduanService)
    {
        $this->middleware('auth');
        $this->pengaduanService = $pengaduanService;
    }

    public function index()
    {
        return response()->view('pengaduan');
    }

    public function buatAduan(Pengaduan $aduan)
    {
        return response()->view('buat-aduan', [
            'wilayah' => auth()->user()->koarmat_id !== null ? Wilayah::where('koarmat_id', auth()->user()->koarmat_id)->get() : Wilayah::all(),
            'allMaterial' => Material::where('is_delete', false)->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        if (isset($request->aduan_id))
            $validatedData = $request->validate([
                'kategori' => ['required', Rule::in(['pemeliharaan', 'pasang_baru'])],
                'dasar_pemeliharaan' => ['required', 'max:50', Rule::in([Pemeliharaan::MONITORING, Pemeliharaan::ADUAN])],
                'jenis' => ['required', 'max:50', Rule::in([JenisPemeliharaan::JARINGAN, JenisPemeliharaan::MANUAL])]
            ]);
        else
            $validatedData = $this->validateAduanForm($request);
        $materials = $this->validateMaterial($request->material, $request->jumlah);
        try {
            $pengaduan = $this->pengaduanService->save($validatedData, $request->aduan_id);
            $this->pengaduanService->saveMaterial($pengaduan, $materials);
        } catch (Exception $e) {
            return back()->with('failure', $e->getMessage());
        }
        $message = $request->aduan_id ? 'Berhasil mengupdate pengaduan' : 'Berhasil membuat pengaduan baru';
        return back()->with('success', $message);
    }

    private function validateAduanForm(Request $request)
    {
        return $request->validate([
            'nama_pengadu' => ['required', 'max:255'],
            'alamat_pengadu' => ['required', 'max:500'],
            'wilayah' => ['required'],
            'no_telepon_pengadu' => ['required', 'max:50'],
            'kategori' => ['required', Rule::in(['pemeliharaan', 'pasang_baru'])],
            'dasar_pemeliharaan' => ['required', 'max:50', Rule::in([Pemeliharaan::MONITORING, Pemeliharaan::ADUAN])],
            'jenis' => ['required', 'max:50', Rule::in([JenisPemeliharaan::JARINGAN, JenisPemeliharaan::MANUAL])]
        ]);
    }

    private function validateMaterial($allMaterial, $allJumlah)
    {
        $materials = [];
        foreach ($allMaterial as $material => $val) {
            if (isset($allJumlah[$material]) && $allJumlah[$material] > 0) {
                $materials[$material] = ['jumlah' => $allJumlah[$material]];
            } else {
                throw ValidationException::withMessages([
                    "jumlah_$material" => 'Silahkan masukan jumlah'
                ]);
            }
        }
        return $materials;
    }
}
