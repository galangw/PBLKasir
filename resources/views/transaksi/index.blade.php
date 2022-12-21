@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-5 bg-white">

            <h2 class="mt-2">Daftar Barang</h2>

            <div class="panel-body">

                {{-- <input type="text" class="form-controller" id="search" name="search"
                        placeholder="Nama Atau Kode Barang"></input> --}}
                <input type="text" name="search" class="form-control w-75 d-inline" id="search"
                    placeholder="Masukkan Nama Atau Kode Barang">

                <table class="table table-bordered table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($barangs as $barang)
                            <tr id="{{ $no++ }}">

                                <td class="row-data">{{ $barang->barang_id }}</td>
                                <td class="row-data">{{ $barang->nama }}</td>
                                <td class="row-data">{{ $barang->harga_jual }}</td>
                                <td>{{ $barang->stok ?? '' }}</td>
                                <td><button class="btn btn-galang ms-auto me-auto"
                                        onclick="tambahKeranjang()">Tambah</button></td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4 bg-white">
            <div class="card">
                <div class="card-body">
                    <h2 class="mt-2">Keranjang</h2>
                    <table id="dynamictable" class="table table-bordered table-hover mt-3">

                        <tr>
                            <td>Kode Barang</td>
                            <td>Nama</td>
                            <td>Harga</td>
                            <td>Hapus</td>
                            <td>Total</td>
                        </tr>

                        {{-- <tbody>

                            <tr id="">

                                <td id="kodebarang" class=""></td>
                                <td id="namabarang" class=""></td>
                                <td id="harga" class=""></td>



                            </tr>

                        </tbody> --}}

                    </table>
                    {{-- <table id="dynamictable" border="1" cellpadding="2">
                        <tr>

                            <td><b>ID</b></td>
                            <td><b>Color</b></td>
                            <td><b>Car</b></td>
                        </tr>
                    </table> --}}
                    <button class="btn btn-galang" onclick="sum()"> Total</button>
                </div>
            </div>
        </div>
        <div class="col-md-3 bg-white">
            <div class="card bg-white">
                <div class="card-body">
                    {{-- <h2 class="mt-2">
                        Total
                    </h2> --}}
                    <h4 style="">Total Harga : </h4>
                    <h4 style="font-weight: bold;"> <span id="totalharga"></span></h4>
                    <h4 style="">Uang Pembeli : </h4>
                    <input style="font-weight:bold;font-size:calc(1.275rem + .3vw)" type="number" name="uang"
                        id="uang" class="form-control">
                    <h4 class="mt-2" style="">Kembalian : </h4>
                    <h4 style="font-weight:bold;text-decoration:italic;"> <span id="kembalian"></span></h4>
                    <button class="btn btn-galang" onclick="sum()"> Proses</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('#search').on('keyup', function() {
            $value = $(this).val();
            $.ajax({
                type: 'get',
                url: '{{ URL::to('search') }}',
                data: {
                    'search': $value
                },
                success: function(data) {
                    $('tbody').html(data);
                }
            });
        })
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'csrftoken': '{{ csrf_token() }}'
            }
        });
    </script>
    <script>
        function tambahKeranjang() {
            var rowId =
                event.target.parentNode.parentNode.id;
            //this gives id of tr whose button was clicked
            var data =
                document.getElementById(rowId).querySelectorAll(".row-data");
            /*returns array of all elements with
            "row-data" class within the row with given id*/

            var kodebarang = data[0].innerHTML;
            var namabarang = data[1].innerHTML;
            var harga = data[2].innerHTML;
            var total;
            console.log(kodebarang);
            console.log(namabarang);
            console.log(harga);

            var table = document.getElementById("dynamictable");
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            // console.log(rowCount);

            row.insertCell(0).innerHTML = kodebarang;
            row.insertCell(1).innerHTML = namabarang;
            row.insertCell(2).innerHTML = harga;
            row.insertCell(3).innerHTML = '<button class="btnDelete  btn-danger">Delete</button>';
            row.insertCell(4).innerHTML =
                '<input type="number" min="1" value="1" name="total" id="totalBarang" class="form-control" >';
            $("#dynamictable").on('click', '.btnDelete', function() {
                $(this).closest('tr').remove();
            });
            // function hapusKeranjang(params) {

            // }




        }

        function sum() {
            var table = document.getElementById("dynamictable"),
                sumVal = 0;
            var totalBarang = document.getElementById("totalBarang").value;
            for (var i = 1; i < table.rows.length; i++) {
                sumVal = sumVal + parseInt(table.rows[i].cells[2].innerHTML);
            }
            var totalHarga = sumVal * totalBarang;
            document.getElementById("totalharga").innerHTML = totalHarga;
            // console.log(sumVal);
        }
        $(document).ready(function() {
            $("#uang").change(function() {
                document.getElementById("kembalian").innerHTML = parseInt($("#uang").val()) - parseInt($(
                    "#totalharga").text());
            });
        });
    </script>
@endsection
