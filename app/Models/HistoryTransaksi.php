<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTransaksi extends Model
{
    use HasFactory;
    protected $primaryKey = "history_transaksi_id";
    protected $guarded = [];
    protected $fillable = ['user_id', 'jumlah', 'total', 'laba'];
    protected $table = "history_transaksis";
    public function barang()
    {
        return $this->belongsToMany(Barang::class, 'barang_history_transaksis', 'history_transaksi_id', 'barang_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function scopeFilterTgl($query, array $tanggal)
    {
        $query->when($tanggal['from'] ?? null, function ($q, $from) {
            $q->where('created_at', '>=', $from);
        });
        $query->when($tanggal['to'] ?? null, function ($q, $to) {
            $q->where('created_at', '<=', $to);
        });
    }
}
