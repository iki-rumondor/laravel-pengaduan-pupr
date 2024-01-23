<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wilayah extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'wilayah';

    public function koarmat(): BelongsTo
    {
        return $this->belongsTo(Koarmat::class);
    }
}
