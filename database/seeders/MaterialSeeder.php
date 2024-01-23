<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::create([
            'name' => 'Lampu'
        ]);
        Material::create([
            'name' => 'MCB'
        ]);
        Material::create([
            'name' => 'Stream clam'
        ]);
        Material::create([
            'name' => 'Piercing'
        ]);
        Material::create([
            'name' => 'Opor Peteng'
        ]);
        Material::create([
            'name' => 'Corong'
        ]);
        Material::create([
            'name' => 'Peteng'
        ]);
        Material::create([
            'name' => 'Isolasi Ban'
        ]);
        Material::create([
            'name' => 'Timer'
        ]);
        Material::create([
            'name' => 'Sensor'
        ]);
        Material::create([
            'name' => 'Trapo'
        ]);
        Material::create([
            'name' => 'Batok Lampu'
        ]);
        Material::create([
            'name' => 'Poto Cel'
        ]);
        Material::create([
            'name' => 'Kontraktor'
        ]);
        Material::create([
            'name' => 'Terminal'
        ]);
        Material::create([
            'name' => 'Enkol'
        ]);
        Material::create([
            'name' => 'KWH Meter'
        ]);
        Material::create([
            'name' => 'Igtitor'
        ]);
        Material::create([
            'name' => 'Kapasitor'
        ]);
        Material::create([
            'name' => ' Stainless Steel Stopping Buckle'
        ]);
    }
}
