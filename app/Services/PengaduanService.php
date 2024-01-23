<?php 

namespace App\Services;

use App\Models\Pengaduan;

interface PengaduanService
{

    function save($validatedData, $aduan_id = null);

    function saveMaterial(Pengaduan $pengaduan, array $material);

    function getOne($id);

    function getByRegion($region);

    function update($validatedData, $id);

    function delete($id);

    function getAllPerMonth($month);

    function getMonths($koarmatId = null);

    function getMonthsAndMaterials($koarmatId = null);

    function getAllByMonthAndKecamatan($month, $array = true);

    function getAllByMonthAndKecamatanAndKoarmat($month, $koarmatId, $array = true);

    function getAllByMonthAndKelurahan($month, $kecamatan, $array = true);

    function getAllPerMonthAndRegion($month, $regionId);

    function getAllAduanMasyarakat();

    function getAllAduanMasyarakatByKoarmat($koarmatId);

}