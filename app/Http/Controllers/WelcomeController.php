<?php

namespace App\Http\Controllers;

use App\Helper\StatusPemeliharaan;
use App\Models\Gambar;
use App\Models\Pengaduan;
use App\Models\Wilayah;
use App\Services\PengaduanService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\ValidationException;

class WelcomeController extends Controller
{
    private PengaduanService $pengaduanService;

    public function __construct(PengaduanService $pengaduanService)
    {
        $this->pengaduanService = $pengaduanService;
    }

    public function index()
    {
        return response()->view('welcome');
    }

    public function buatAduan()
    {
        return response()->view('masyarakat.buat-aduan', [
            'wilayah' => Wilayah::all(),
        ]);
    }

    public function storeAduan(Request $request)
    {
        $today = Carbon::today()->toDateString();
        $pengaduan = Pengaduan::where("ip_address", $request->ip())
            ->whereDate('created_at', $today)
            ->whereNot('ket', StatusPemeliharaan::SUDAH_DIPROSES)
            ->first();

        if ($pengaduan) {
            return back()->with('failure', "Aduan Anda Sedang Kami Proses, Silahkan Tunggu Hingga Aduan Selesai Diproses");
        }

        $validatedData = $request->validate([
            'nama_pengadu' => ['required', 'max:255'],
            'alamat_pengadu' => ['required', 'max:500'],
            'wilayah' => ['required'],
            'no_telepon_pengadu' => ['required', 'max:50'],
            'bukti_pendukung' => ['required', File::image()]
        ]);

        if (!isset($request->latitude) || !isset($request->longitude))
            throw ValidationException::withMessages([
                'titik_lokasi' => 'Silahkan pilih titik lokasi'
            ]);
        $validatedData['aduan_masyarakat'] = true;
        $validatedData['latitude'] = $request->latitude;
        $validatedData['longitude'] = $request->longitude;
        $validatedData['ip_address'] = $request->ip();
        try {
            $pengaduan = $this->pengaduanService->save($validatedData);
            $imgName = time() . '.jpg';
            $request->bukti_pendukung->storePubliclyAs('public/pengaduan', $imgName);
            Gambar::create([
                'pengaduan_id' => $pengaduan->id,
                'name' => $imgName
            ]);
        } catch (Exception $e) {
            return back()->with('failure', $e->getMessage());
        }
        return back()->with('success', 'Berhasil membuat pengaduan baru');
    }
}
