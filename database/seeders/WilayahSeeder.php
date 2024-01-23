<?php

namespace Database\Seeders;

use App\Models\Koarmat;
use App\Models\Wilayah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $koarmat1 = Koarmat::create([
            'name' => 'koarmat 1'
        ]);
        $koarmat2 = Koarmat::create([
            'name' => 'koarmat 2'
        ]);
        $koarmat3 = Koarmat::create([
            'name' => 'koarmat 3'
        ]);

        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Dungingi',
            'kelurahan' => 'Tuladenggi'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Dungingi',
            'kelurahan' => 'Tomulabutao'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Dungingi',
            'kelurahan' => 'Tomsel'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Dungingi',
            'kelurahan' => 'Libuo'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Dungingi',
            'kelurahan' => 'Huangobotu'
        ]);

        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Dumboraya',
            'kelurahan' => 'Botu'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Dumboraya',
            'kelurahan' => 'Bugis'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Dumboraya',
            'kelurahan' => 'Leato Selatan'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Dumboraya',
            'kelurahan' => 'Leato Utara'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Dumboraya',
            'kelurahan' => 'Talumolo'
        ]);

        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Barat',
            'kelurahan' => 'Tenilo'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Barat',
            'kelurahan' => 'Pilolodaa'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Barat',
            'kelurahan' => 'Molosipat W'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Barat',
            'kelurahan' => 'Lekobalo'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Barat',
            'kelurahan' => 'Dembe 1'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Barat',
            'kelurahan' => 'Buliide'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Barat',
            'kelurahan' => 'Buladu'
        ]);

        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Selatan',
            'kelurahan' => 'Biawao'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Selatan',
            'kelurahan' => 'Biau'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Selatan',
            'kelurahan' => 'Limba B'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Selatan',
            'kelurahan' => 'Limba U1'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Kota Selatan',
            'kelurahan' => 'Limba U2'
        ]);

        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Hulanthalangi',
            'kelurahan' => 'Tenda'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Hulanthalangi',
            'kelurahan' => 'Tanjung Kramat'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Hulanthalangi',
            'kelurahan' => 'Siendeng'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Hulanthalangi',
            'kelurahan' => 'Donggala'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat2->id,
            'kecamatan' => 'Hulanthalangi',
            'kelurahan' => 'Pohe'
        ]);

        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Tengah',
            'kelurahan' => 'Wumialo'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Tengah',
            'kelurahan' => 'Paguyaman'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Tengah',
            'kelurahan' => 'Liluwo'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Tengah',
            'kelurahan' => 'Dulalowo'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Tengah',
            'kelurahan' => 'Dultim'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Tengah',
            'kelurahan' => 'Pulubala'
        ]);

        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Kota Timur',
            'kelurahan' => 'Tamalate'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Kota Timur',
            'kelurahan' => 'Padebuolo'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Kota Timur',
            'kelurahan' => 'Moodu'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Kota Timur',
            'kelurahan' => 'Helut'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Kota Timur',
            'kelurahan' => 'Helsel'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat3->id,
            'kecamatan' => 'Kota Timur',
            'kelurahan' => 'Ipilo'
        ]);

        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Utara',
            'kelurahan' => 'Dulomo Selatan'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Utara',
            'kelurahan' => 'Dulomo Utara'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Utara',
            'kelurahan' => 'Dembe II'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Utara',
            'kelurahan' => 'Dembe Jaya'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Utara',
            'kelurahan' => 'Wongkaditi Barat'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Kota Utara',
            'kelurahan' => 'Wongkaditi Timur'
        ]);

        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Sipatana',
            'kelurahan' => 'Bulotadaa Barat'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Sipatana',
            'kelurahan' => 'Bulotadaa Timur'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Sipatana',
            'kelurahan' => 'Molosipat U'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Sipatana',
            'kelurahan' => 'Tanggikiki'
        ]);
        Wilayah::create([
            'koarmat_id' => $koarmat1->id,
            'kecamatan' => 'Sipatana',
            'kelurahan' => 'Tapa'
        ]);
    }
}
