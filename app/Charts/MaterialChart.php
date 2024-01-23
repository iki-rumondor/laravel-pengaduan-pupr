<?php

namespace App\Charts;

use App\Models\Pengaduan;
use App\Services\PengaduanService;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MaterialChart
{
    protected $chart;
    private $pengaduanService;

    public function __construct(LarapexChart $chart, PengaduanService $pengaduanService)
    {
        $this->chart = $chart;
        $this->pengaduanService = $pengaduanService;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $this->chart = $this->chart->barChart()
            ->setTitle('Penggunaan material.')
            ->setFontFamily('Poppins')
            ->setFontColor('#fff');
        $xaxis = [];
        $dataset = [];
        $months = $this->pengaduanService->getMonthsAndMaterials(auth()->user()->koarmat_id)->reverse();
        foreach ($months as $month) {
            $bulan = Carbon::parse($month->bulan)->format('m');
            $xaxis[] = Carbon::parse($month->bulan)->translatedFormat('F Y');
            $allPengaduan = Pengaduan::with('material')->whereMonth('created_at', Carbon::parse($month->bulan)->month)->whereYear('created_at', Carbon::parse($month->bulan)->year);
            if (auth()->user()->koarmat_id) {
                $allPengaduan = $allPengaduan->whereHas('wilayah', function($wilayah) {
                    $wilayah->where('koarmat_id', auth()->user()->koarmat_id);
                })->get();
            } else 
                $allPengaduan = $allPengaduan->get();
            foreach ($allPengaduan as $pengaduan) {
                foreach($pengaduan->material as $material) {
                    isset($dataset[$material->name][$bulan]) ? $dataset[$material->name][$bulan] += $material->pivot->jumlah : $dataset[$material->name][$bulan] = $material->pivot->jumlah;
                }
            }
        }
        foreach($dataset as $material => $data_material) {
            $data = [];
            foreach ($months as $month) {
                $bulan = Carbon::parse($month->bulan)->format('m');
                $data[] = isset($data_material[$bulan]) ? $data_material[$bulan] : 0;
            }
            $this->chart->addData($material, $data);
        }
        $this->chart->setXAxis($xaxis);
        return $this->chart;
    }
}
