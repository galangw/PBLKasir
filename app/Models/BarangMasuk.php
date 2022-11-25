<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $primaryKey = "barang_masuk_id";
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_masuk_id');
    }
}
