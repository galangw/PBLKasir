<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTransaksi extends Model
{
    use HasFactory;
    protected $primaryKey = "history_transaksi_id";
    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'barang_history_transaksis', 'history_transaksi_id', 'barang_id');
    }
    public function user()
    {
        return $this->belongsToMany(User::class, 'user_history_transaksis', 'history_transaksi_id', 'user_id');
    }
}
