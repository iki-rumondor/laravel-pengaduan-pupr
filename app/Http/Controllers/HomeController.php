<?php

namespace App\Http\Controllers;

use App\Charts\MaterialChart;
use App\Models\Pengaduan;
use App\Services\PengaduanService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private PengaduanService $pengaduanService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PengaduanService $pengaduanService)
    {
        $this->middleware('auth');
        $this->pengaduanService = $pengaduanService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(MaterialChart $chart)
    {

        $bulanArray = [];
        $jumlahDataArray = [];

        $tanggalSaatIni = Carbon::now();
        $tanggalLimaBulanLalu = $tanggalSaatIni->copy()->subMonths(5);

        while ($tanggalLimaBulanLalu->lessThanOrEqualTo($tanggalSaatIni)) {
            $awalBulan = $tanggalLimaBulanLalu->copy()->startOfMonth();
            $akhirBulan = $tanggalLimaBulanLalu->copy()->endOfMonth();
            $jumlahData = Pengaduan::whereBetween('created_at', [$awalBulan, $akhirBulan])->count();
            $bulanArray[] = $tanggalLimaBulanLalu->format('Y-m');
            $jumlahDataArray[] = $jumlahData;
            $tanggalLimaBulanLalu->addMonth();
        }

        return view('home', [
            'labels' => json_encode($bulanArray),
            'values' => json_encode($jumlahDataArray),
            'chart' => $chart->build(),
            'show_grafik' => count($this->pengaduanService->getMonthsAndMaterials(auth()->user()->koarmat_id)) > 0
        ]);
    }
}
