<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $primaryKey = 'barang_id';
    protected $guarded = [];
    protected $keyType = 'string';
    public $incrementing = false;
    // protected $fillable = [
    //     'kategori_id',
    //     'barang_id',
    //     'supplier_id',
    //     'nama',
    //     'harga_beli',
    //     'harga_jual',
    //     'stok'
    // ];
    public function scopeCari($query, $kode, $nama)
    {
        $query->when($kode ?? null, function ($q, $kode) {
            $q->where('barang_id', $kode);
        });
        $query->when($nama ?? null, function ($q, $nama) {
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
