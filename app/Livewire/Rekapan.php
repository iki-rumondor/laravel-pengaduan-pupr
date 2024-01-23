<?php

namespace App\Livewire;

use App\Exports\PengaduanExport;
use App\Models\Pengaduan;
use App\Services\PengaduanService;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Rekapan extends Component
{
    public $selectedMonth, $selectedKecamatan, $selectedKelurahan, $selectedPengaduan, $wilayahId;
    public $allPerMonth, $allMonth, $allKecamatan, $allKelurahanByKecamatan, $isShowPengaduanInKec, $showDetail;

    protected function queryString()
    {
        return [
            'selectedMonth' => [
                'as' => 'bulan',
                'except' => ''
            ],
            'selectedKecamatan' => [
                'as' => 'kecamatan',
                'except' => ''
            ],
            'selectedKelurahan' => [
                'as' => 'kelurahan',
                'except' => ''
            ]
        ];
    }

    public function mount()
    {
        $this->isShowPengaduanInKec = false;
        $this->showDetail = false;
    }

    public function render()
    {
        try {
            $this->allMonth = $this->getPengaduanService()->getMonths(auth()->user()->koarmat_id);
            $this->allKecamatan = $this->selectedMonth ? (auth()->user()->koarmat_id !== null ? $this->getPengaduanService()->getAllByMonthAndKecamatanAndKoarmat($this->selectedMonth, auth()->user()->koarmat_id) : $this->getPengaduanService()->getAllByMonthAndKecamatan($this->selectedMonth)) : [];
            $this->allKelurahanByKecamatan = $this->selectedMonth && $this->selectedKecamatan ? $this->getPengaduanService()->getAllByMonthAndKelurahan($this->selectedMonth, $this->selectedKecamatan) : [];
        } catch (Exception $e) {
            return redirect()->route('rekap.pengaduan');
        }
        return view('livewire.rekapan');
    }

    public function selectMonth($month)
    {
        $this->selectedMonth = $month;
    }

    public function selectKecamatan($kecamatan)
    {
        $this->selectedKecamatan = $kecamatan;
        $this->allPerMonth = $this->allKecamatan[$kecamatan];
    }

    public function selectKelurahan($kelurahan)
    {
        $this->selectedKelurahan = $kelurahan;
        $this->allPerMonth = $this->allKelurahanByKecamatan[$kelurahan];
        if (count($this->allPerMonth) > 0) {
            $firstData = $this->allPerMonth[0];
            $this->wilayahId = $firstData->wilayah_id;
        }
    }

    public function toMonth()
    {
        $this->selectedMonth = '';
        $this->selectedKecamatan = '';
        $this->selectedKelurahan = '';
        $this->isShowPengaduanInKec = false;
        $this->wilayahId = null;
    }

    public function toKecamatan()
    {
        $this->selectedKecamatan = '';
        $this->selectedKelurahan = '';
        $this->isShowPengaduanInKec = false;
        $this->wilayahId = null;
    }

    public function toKelurahan()
    {
        $this->selectedKelurahan = '';
        $this->allPerMonth = $this->allKecamatan[$this->selectedKecamatan];
        $this->isShowPengaduanInKec = false;
        $this->wilayahId = null;
    }

    public function showPengaduanInKec(bool $show)
    {
        $this->isShowPengaduanInKec = $show;
    }

    public function showPengaduanDetail($pengaduanId)
    {
        $this->showDetail = true;
        $this->selectedPengaduan = Pengaduan::findOrFail($pengaduanId);
    }

    #[On('back-to-show-all')]
    public function backToShowAll()
    {
        $this->showDetail = false;
    }

    public function downloadExcel()
    {
        $month = $this->selectedMonth ? str_replace(' ', '-', $this->selectedMonth) : null;
        $kecamatan = $this->selectedKecamatan ? str_replace(' ', '-', $this->selectedKecamatan): null;
        $kelurahan = $this->selectedKelurahan ? str_replace(' ', '-', $this->selectedKelurahan) : null;
        $fileName = ($month ? strtolower($month) : date('M Y')) . ($kecamatan ? '-' . strtolower($kecamatan) : '') . ($kelurahan ? '-' . strtolower($kelurahan) : '') . '.xlsx';
        return Excel::download(new PengaduanExport($this->selectedMonth, $this->selectedKecamatan, $this->wilayahId, $this->getPengaduanService()), $fileName);
    }

    private function getPengaduanService()
    {
        return app(PengaduanService::class);
    }
}
