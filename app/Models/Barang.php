<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $primaryKey = "barang_id";
    protected $guarded = ['barang_id'];
    public function scopeCari($query, $nama)
    {
        $query->when($nama ?? false, function ($q) use ($nama) {
            $q->where('nama', 'LIKE', "%" . $nama . "%");
        });
        return $query;
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class, 'barang_id');
    }
    public function historyTransaksi()
    {
        return $this->belongsToMany(HistoryTransaksi::class, 'barang_history_transaksis', 'barang_id', 'history_transaksi_id');
    }
}
