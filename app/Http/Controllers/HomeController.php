<?php

namespace App\Http\Controllers;

use app\Models\Barang;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $barang = Barang::latest()->get();
        $totalBarang = $barang->count();
        return view('home', compact('totalBarang'));
    }
}
