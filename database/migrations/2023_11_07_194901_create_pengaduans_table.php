<?php

use App\Helper\StatusPemeliharaan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wilayah_id');
            $table->string('nama_pengadu', 255);
            $table->string('alamat_pengadu', 500);
            $table->string('no_telepon_pengadu', 50);
            $table->string('kategori', 50)->nullable();
            $table->string('dasar_pemeliharaan', 50)->nullable();
            $table->string('jenis', 50)->nullable();
            $table->string('ket', 255)->default(StatusPemeliharaan::BELUM_DIPROSES);
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->boolean('aduan_masyarakat')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
