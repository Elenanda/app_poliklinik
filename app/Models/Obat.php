<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'obat';

    protected $fillable = [
        'nama_obat',
        'kemasan',
        'harga',
        'stok',
    ];

    public function detailPeriksas()
    {
        return $this->hasMany(DetailPeriksa::class, 'id_obat');
    }

    /**
     * Cek apakah stok menipis (kurang dari 10).
     */
    public function getIsLowStockAttribute(): bool
    {
        return $this->stok > 0 && $this->stok < 10;
    }

    /**
     * Cek apakah stok habis.
     */
    public function getIsOutOfStockAttribute(): bool
    {
        return $this->stok <= 0;
    }
}