<?php

namespace App\Exports;

use App\Services\PengaduanService;
use Exception;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class PengaduanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents, WithDrawings
{
    protected $month;
    protected $kecamatan;
    protected $wilayahId;

    private PengaduanService $pengaduanService;

    public function __construct($month, $kecamatan = null, $wilayahId = null, PengaduanService $pengaduanService)
    {
        $this->month = $month;
        $this->kecamatan = $kecamatan;
        $this->wilayahId = $wilayahId;
        $this->pengaduanService = $pengaduanService;
    }

    public function collection()
    {
        if ($this->kecamatan !== null && $this->wilayahId == null)
            return $this->pengaduanService->getAllByMonthAndKelurahan($this->month, $this->kecamatan, false);
        if ($this->wilayahId !== null)
            return $this->pengaduanService->getAllPerMonthAndRegion($this->month, $this->wilayahId);
    }

    public function map($pengaduan): array
    {
        $material = '';
        foreach ($pengaduan->material()->withPivot('jumlah')->get() as $key => $material) {
            $material = ($key > 1 ? ', ' : '') . $material->pivot->jumlah . ' buah ' . $material->name;
        }
        return [
            $pengaduan->created_at->translatedFormat('d F Y'),
            $pengaduan->alamat_pengadu . ', ' . optional($pengaduan->wilayah)->kelurahan . ', ' . optional($pengaduan->wilayah)->kecamatan,
            $pengaduan->nama_pengadu,
            $pengaduan->no_telepon_pengadu,
            $pengaduan->dasar_pemeliharaan,
            $material,
            $pengaduan->jenis,
            $pengaduan->ket,
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Alamat',
            'Nama Pengadu',
            'No Telepon Pengadu',
            'Dasar Pemeliharaan',
            'Material',
            'Jenis',
            'Keterangan',
            'Gambar'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:Z1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ]);
    }

    public function drawings()
    {
        $allDrawing = [];
        $allPengaduan = [];
        if ($this->kecamatan !== null && $this->wilayahId == null)
            $allPengaduan = $this->pengaduanService->getAllByMonthAndKelurahan($this->month, $this->kecamatan, false);
        if ($this->wilayahId !== null)
            $allPengaduan = $this->pengaduanService->getAllPerMonthAndRegion($this->month, $this->wilayahId);
        foreach ($allPengaduan as $key => $pengaduan) {
            if (isset($pengaduan->gambar[0])) {
                $drawing = new Drawing();
                $drawing->setName('Logo');
                $drawing->setPath(public_path('/storage/pengaduan/' . $pengaduan->gambar[0]->name));
                $drawing->setHeight(50);
                $drawing->setWidth(100);
                $drawing->setCoordinates('I' . $key + 2);
                $drawing->setOffsetX(0);
                $drawing->setOffsetY(0);
                $allDrawing[] = $drawing;
            }
        }
        return $allDrawing;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getStyle('A1:Z1')->getAlignment()->setWrapText(true);
                $event->sheet->getDelegate()->getStyle('A1:Z1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:Z1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $rowCount = count($this->collection());
                for ($row = 2; $row <= $rowCount + 1; $row++) {
                    $event->sheet->getRowDimension($row)->setRowHeight(80);
                    $event->sheet->getDelegate()->getStyle('A'. $row .':Z' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $event->sheet->getDelegate()->getStyle('A'. $row .':Z' . $row)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                }

                $event->sheet->getColumnDimension('I')->setWidth(20);
                $event->sheet->autoSize();
            }
        ];
    }
}