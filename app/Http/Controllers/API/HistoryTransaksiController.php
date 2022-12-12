<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangHistoryTransaksi;
use App\Models\HistoryTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoryTransaksiController extends Controller
{
    public function transaksi(Request $request)
    {
        /*
        format request
        {
            "data":[
            {
                "barang_id":10,
                "jumlah":10
            },
            {
                "barang_id":11,
                "jumlah":10
            }]
        }
        */
        $barangId = [];
        $barangJumlah = [];
        foreach ($request->data as $item) {
            $barangId[] = $item['barang_id'];
            $barangJumlah[] = $item['jumlah'];
        }
        DB::beginTransaction();
        try {
            $barang = Barang::whereIn('barang_id', $barangId)->get();
            $caseBarang = [];
            foreach ($barang as $key => $value) {
                $caseBarang[] = "WHEN " . $barangId[$key] . " THEN ?";
                $history = new HistoryTransaksi();
                $history->user_id = Auth::user()->id;
                $history->jumlah = $barangJumlah[$key];
                $history->total = $value->harga_jual * $barangJumlah[$key];
                $history->laba = ($value->harga_jual * $barangJumlah[$key]) - ($value->harga_beli * $barangJumlah[$key]);
                $history->save();
                $history->barang()->attach($barangId[$key]);
            }
            $caseBarang = implode(" ", $caseBarang);
            $barangId = implode(',', $barangId);
            DB::update("UPDATE barangs SET stok = stok - CASE " . $caseBarang . " END WHERE barang_id in (" . $barangId . ")", $barangJumlah);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => "Sukses Melakukan Transaksi"
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
