<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $primaryKey = "barang_masuk_id";
    protected $guarded = ['barang_masuk_id'];
    public function scopeFilterTgl($query, array $tanggal)
    {
        $query->when($tanggal['from'] ?? null, function ($q, $from) {
            $q->where('created_at', '>=', $from);
        });
        $query->when($tanggal['to'] ?? null, function ($q, $to) {
            $q->where('created_at', '<=', $to);
        });
        return $query;
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
