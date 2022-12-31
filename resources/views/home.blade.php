@extends('layouts.app')

@section('content')
    @if (Auth::user()->role == 'admin')
        <div class="container-fluid mt-2" style="background-color: white;">
            <div class="row bg-white ">
                <div class="col bg-white mt-4 ">

                    <div class="card-body btn-galang" style="">
                        <h5 class="card-title">Total Barang</h5>
                        <h3>{{ $totalBarang }}</h2>
                    </div>
                    <div class="card-footer btn-galang card-dash"><a href="/barang">Selengkapnya</a></div>

                </div>

                <div class="col bg-white mt-4 ">

                    <div class="card-body btn-galang" style="">
                        <h5 class="card-title">Transaksi Hari Ini</h5>
                        <h3>{{ number_format($history_transaksi) }}</h2>
                    </div>
                    <div class="card-footer btn-galang card-dash"><a href="/lihathistory">Selengkapnya</a></div>

                </div>


                <div class="col bg-white mt-4 ">

                    <div class="card-body btn-galang" style="">
                        <h5 class="card-title">Penjualan Hari Ini</h5>
                        <h3>Rp. {{ number_format($total_today, 0, ',', '.') }}</h2>
                    </div>
                    <div class="card-footer btn-galang card-dash"><a href="/lihathistory">Selengkapnya</a></div>

                </div>
                <div class="col bg-white mt-4 ">

                    <div class="card-body btn-galang" style="">
                        <h5 class="card-title">Laba Hari Ini</h5>
                        <h3>Rp. {{ number_format($laba_today, 0, ',', '.') }}</h2>
                    </div>
                    <div class="card-footer btn-galang card-dash"><a href="/lihathistory">Selengkapnya</a></div>

                </div>
            </div>

        </div>
    @else
        <script>
            // window.alert('Anda tidak memiliki akses ke halaman ini');
            // window.location = '/home';
        </script>
    @endif
@endsection
