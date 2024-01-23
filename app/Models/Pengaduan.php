<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengaduan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'pengaduan';

    protected $with = ['gambar'];

    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function scopeFilters($query, array $filters)
    {
        $query->when($filters['kategori'] ?? false, function($pengaduan) use ($filters) {
            $pengaduan->where('kategori', $filters['kategori']);
        });

        $query->when($filters['search'] ?? false, function($pengaduan) use ($filters) {
            if ($filters['search'] != '' && $filters['search'] !== null)
                $pengaduan->whereHas('wilayah', function($wilayah) use ($filters) {
                    $wilayah->where('kecamatan', 'LIKE', '%' . $filters['search'] . '%')->orWhere('kelurahan', 'LIKE', '%' . $filters['search'] . '%');
                })->orWhere('nama_pengadu', 'LIKE', '%' . $filters['search'] . '%');
        });
    }

    public function material(): BelongsToMany
    {
        return $this->belongsToMany(Material::class)->withPivot('jumlah');
    }

    public function gambar():HasMany
    {
        return $this->hasMany(Gambar::class);
    }
}
