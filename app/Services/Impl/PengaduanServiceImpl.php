<?php 

namespace App\Services\Impl;

use App\Helper\StatusPemeliharaan;
use App\Models\Koarmat;
use App\Models\Material;
use App\Models\Pengaduan;
use App\Models\Wilayah;
use App\Services\PengaduanService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PengaduanServiceImpl implements PengaduanService
{

    public function save($validatedData, $aduan_id = null)
    {
        if ($aduan_id) {
            $aduan = Pengaduan::findOrFail($aduan_id);
            $validatedData['status'] = StatusPemeliharaan::SEMENTARA_DIPROSES;
            $aduan->update($validatedData);
            return $aduan;
        }
        $validatedData['wilayah_id'] = $validatedData['wilayah'];
        return Pengaduan::create($validatedData);
    }

    public function saveMaterial(Pengaduan $pengaduan, array $material)
    {
        DB::transaction(function() use ($pengaduan, $material) {
            foreach ($material as $id => $mat) {
                $materialSelect = Material::find($id);
                if ($materialSelect->stok >= $mat['jumlah']) {
                    $materialSelect->stok -= $mat['jumlah'];
                    $materialSelect->save();
                    $pengaduan->material()->sync($material);
                } else {
                    throw new Exception('Jumlah melebihi stok material ' . $materialSelect->name . ' tersedia');
                }
            }
        });
    }

    public function getOne($id)
    {
        return Pengaduan::find($id);
    }

    public function getByRegion($region)
    {
        return Pengaduan::where('region', $region)->latest()->get();
    }

    public function update($validatedData, $id)
    {
        $pengaduan = Pengaduan::find($id);
        if ($pengaduan == null)
            return;
        return $pengaduan->update($validatedData);
    }

    public function delete($id)
    {
        $pengaduan = Pengaduan::find($id);
        if ($pengaduan)
            $pengaduan->delete();
    }

    public function getAllPerMonth($month)
    {
        return Pengaduan::where(DB::raw('DATE_FORMAT(created_at, "%M %Y")'), $month)->get();
    }

    public function getMonths($koarmatId = null)
    {
        if ($koarmatId == null)
            return Pengaduan::select(DB::raw('DATE_FORMAT(created_at, "%M %Y") AS bulan'), DB::raw('COUNT(*) AS jumlah_data'))
                ->groupBy('bulan')
                ->distinct()
                ->orderBy('bulan', 'desc')
                ->get();
        else 
            return Pengaduan::select(DB::raw('DATE_FORMAT(created_at, "%M %Y") AS bulan'), DB::raw('COUNT(*) AS jumlah_data'))
                ->groupBy('bulan')
                ->whereHas('wilayah', function($wilayah) use ($koarmatId) {
                    $wilayah->where('koarmat_id', $koarmatId);
                })
                ->distinct()
                ->orderBy('bulan', 'desc')
                ->get();
    }

    public function getMonthsAndMaterials($koarmatId = null)
    {
        if ($koarmatId == null)
            return Pengaduan::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS bulan'))
                ->with('material')
                ->groupBy('bulan')
                ->orderBy('bulan', 'DESC')
                ->take(2)
                ->get();
        else 
            return Pengaduan::whereHas('wilayah', function($wilayah) use ($koarmatId) {
                    $wilayah->where('koarmat_id', $koarmatId);
                })
                ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") AS bulan'))
                ->with('material')
                ->groupBy('bulan')
                ->orderBy('bulan', 'DESC')
                ->take(2)
                ->get();
    }

    public function getAllByMonthAndKecamatan($month, $array = true)
    {
        $allPengaduan = [];
        $allPengaduanCollection = new Collection();
        foreach (Wilayah::select('kecamatan')->distinct()->get() as $kecamatan) {
            $pengaduanPerKecamatan = new Collection();
            foreach (Wilayah::where('kecamatan', $kecamatan->kecamatan)->get() as $kelurahan) {
                foreach ($this->getAllPerMonthAndRegion($month, $kelurahan->id) as $pengaduan) {
                    $pengaduanPerKecamatan->push($pengaduan);
                    $allPengaduanCollection->push($pengaduan);
                }
            }
            $allPengaduan[$kecamatan->kecamatan] = $pengaduanPerKecamatan;
        }
        return $array ? $allPengaduan : $allPengaduanCollection;
    }

    public function getAllByMonthAndKecamatanAndKoarmat($month, $koarmatId, $array = true)
    {
        if (Koarmat::find($koarmatId) == null)
            return [];
        $allPengaduan = [];
        $allPengaduanCollection = new Collection();
        foreach (Wilayah::select('kecamatan')->where('koarmat_id', $koarmatId)->distinct()->get() as $kecamatan) {
            $pengaduanPerKecamatan = new Collection();
            foreach (Wilayah::where('kecamatan', $kecamatan->kecamatan)->get() as $kelurahan) {
                foreach ($this->getAllPerMonthAndRegion($month, $kelurahan->id) as $pengaduan) {
                    $pengaduanPerKecamatan->push($pengaduan);
                    $allPengaduanCollection->push($pengaduan);
                }
            }
            $allPengaduan[$kecamatan->kecamatan] = $pengaduanPerKecamatan;
        }
        return $array ? $allPengaduan : $allPengaduanCollection;
    }

    public function getAllByMonthAndKelurahan($month, $kecamatan, $array = true)
    {
        $allPengaduan = [];
        $allPengaduanCollection = new Collection();
        foreach (Wilayah::where('kecamatan', $kecamatan)->get() as $kelurahan) {
            $pengaduanPerKelurahan = new Collection();
            foreach ($this->getAllPerMonthAndRegion($month, $kelurahan->id) as $pengaduan) {
                $pengaduanPerKelurahan->push($pengaduan);
                $allPengaduanCollection->push($pengaduan);
            }
            $allPengaduan[$kelurahan->kelurahan] = $pengaduanPerKelurahan;
        }
        return $array ? $allPengaduan : $allPengaduanCollection;
    }

    public function getAllPerMonthAndRegion($month, $regionId)
    {
        return Pengaduan::where(DB::raw('DATE_FORMAT(created_at, "%M %Y")'), $month)->where('wilayah_id', $regionId)->get();
    }

    public function getAllAduanMasyarakat()
    {
        return Pengaduan::where('aduan_masyarakat', true)->where('kategori', null)->where('dasar_pemeliharaan', null)->where('jenis', null)->latest()->paginate(15);
    }

    public function getAllAduanMasyarakatByKoarmat($koarmatId)
    {
        return Pengaduan::whereHas('wilayah', function($wilayah) use ($koarmatId) {
            $wilayah->where('koarmat_id', $koarmatId);
        })->where('aduan_masyarakat', true)->where('kategori', null)->where('dasar_pemeliharaan', null)->where('jenis', null)->latest()->paginate(15);
    }

}