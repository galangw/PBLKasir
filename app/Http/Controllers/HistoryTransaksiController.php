<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Barang;

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
}
