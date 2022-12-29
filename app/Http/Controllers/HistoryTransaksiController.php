<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use App\Models\BarangHistoryTransaksi;
use App\Models\BarangMasuk;
use App\Models\HistoryTransaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HistoryTransaksiController extends Controller
{
    public function index()
    {
        // return view('transaksi.index');
        $barangs = Barang::latest()->get();

        return view('transaksi.index', compact('barangs'));
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = "";
            $barangs = Barang::where('nama', 'like', "%" . $request->search . "%")
                ->orWhere('barang_id', 'like', "%" . $request->search . "%")
                ->paginate(5);
            // $barangs = DB::table('barangs')->where('nama', 'LIKE', '%' . $request->search . "%")->get();
            if ($barangs) {
                foreach ($barangs as  $barang) {
                    $output .= '<tr>' .
                        '<td>' . $barang->barang_id . '</td>' .
                        '<td>' . $barang->nama . '</td>' .
                        '<td>' . $barang->harga_jual . '</td>' .
                        '<td>' . $barang->stok . '</td>' .
                        '</tr>';
                }
                return Response($output);
            }
        }
    }
    public function transaksi(Request $request)
    {

        $barangId = [];
        $barangJumlah = [];
        foreach ($request->data as $item) {
            $barangId[] = $item['barang_id'];
            $barangJumlah[] = $item['jumlah'];
        }
        DB::beginTransaction();
        try {
            $barang = Barang::whereIn('barang_id', $barangId)->get();
            foreach ($barang as $key => $value) {
                $history = new HistoryTransaksi();
                $history->user_id = Auth::user()->id;
                $history->jumlah = $barangJumlah[$key];
                $history->total = $value->harga_jual * $barangJumlah[$key];
                $history->laba = ($value->harga_jual * $barangJumlah[$key]) - ($value->harga_beli * $barangJumlah[$key]);
                $history->save();
                $history->barang()->attach($barangId[$key]);
                $value->stok = $value->stok - $barangJumlah[$key];
                $value->save();
            }
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
    function getHistory()
    {
        $history = HistoryTransaksi::with('barang')->get();
        return view('transaksi.history', compact('history'));
    }
}
