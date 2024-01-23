<?php

namespace App\Http\Controllers;

use App\Charts\MaterialChart;
use App\Services\PengaduanService;
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
        return view('home', [
            'chart' => $chart->build(),
            'show_grafik' => count($this->pengaduanService->getMonthsAndMaterials(auth()->user()->koarmat_id)) > 0 
        ]);
    }
}
