@extends('layouts.app')
@section('head')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/table-to-json@1.0.0/lib/jquery.tabletojson.min.js"
        integrity="sha256-H8xrCe0tZFi/C2CgxkmiGksqVaxhW0PFcUKZJZo1yNU=" crossorigin="anonymous"></script>
@endsection
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
                            <td data-override="barang_id">Kode Barang</td>
                            <td>Nama</td>
                            <td>Harga</td>
                            <td>Hapus</td>
                            <td data-override="jumlah">Quantity</td>
                            <td>Total</td>
                        </tr>

                        {{-- <tbody>

                            <tr id="">

                                <td id="kodebarang" class=""></td>
                                <td id="namabarang" class=""></td>
                                <td id="harga" class=""></td>
                                <td id="delete" class=""><button class="btnDelete  btn-danger">Delete</button></td>
                                <td id="total" class=""></td>



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
                    {{-- <button class="btn btn-galang" onclick="sum()"> Total</button> --}}
                </div>
            </div>
        </div>
        <div class="col-md-3 bg-white">
            <div class="card bg-white">
                <div class="card-body">
                    {{-- <h2 class="mt-2">
                        Total
                    </h2> --}}
                    <h4 style="">Total Harga :</h4>
                    <h4 style="font-weight: bold;"> Rp. <span id="totalharga"></span></h4>
                    <h4 style="">Uang Pembeli : </h4>
                    <input style="font-weight:bold;font-size:calc(1.275rem + .3vw)" type="number" name="uang"
                        id="uang" class="form-control">
                    <h4 class="mt-2" style="">Kembalian : </h4>
                    <h4 style="font-weight:bold;text-decoration:italic;">Rp. <span id="kembalian"></span></h4>
                    <button class="btn btn-galang" onclick="proses()"> Proses</button>
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
            var isiTabel = ($('#dynamictable td:nth-child(1)').map(function() {
                return $(this).text();
            }).get());
            // var arrayIsiTabel = isiTabel.split(',');
            // console.log(isiTabel);

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
            // console.log(kodebarang);
            // console.log(namabarang);
            // console.log(harga);

            var table = document.getElementById("dynamictable");
            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            // console.log(rowCount);


            // function hapusKeranjang(params) {

            // }
            function tambahBarang() {
                var tambahkodebarang = row.insertCell(0);
                tambahkodebarang.innerHTML = kodebarang;
                tambahkodebarang.className = "kodebarang";
                // tambahkodebarang.setAttribute('data-override', 'barang_id')
                // row.insertCell(0).innerHTML = kodebarang;
                var tambahnamabarang = row.insertCell(1);
                tambahnamabarang.innerHTML = namabarang;
                tambahnamabarang.className = "namabarang";
                // row.insertCell(1).innerHTML = namabarang;
                var tambahhargabarang = row.insertCell(2);
                tambahhargabarang.innerHTML = harga;
                tambahhargabarang.className = "harga";
                // row.insertCell(2).innerHTML = harga;
                row.insertCell(3).innerHTML = '<button class="btnDelete  btn-danger">Delete</button>';
                row.insertCell(4).innerHTML =
                    '<input type="number" min="1" value="1" name="total" id="totalBarang" class="form-control totalBarang" >';
                row.insertCell(5).innerHTML =
                    '<span class="total">' + harga + '</span>';
                // row.insertCell(4).innerHTML =
                //     '<div class="quantity "> <input type="button" value="-" class="minus" field="quantity"><input type="number" id="quantity" name="quantity" value="1" class="qty" style="width:25%" /><input type="button" value="+" class="plus" field="quantity"> </div>';
                // var total = harga * $('#totalBarang').val();

                // row.insertCell(5).innerHTML =
                //     total;


            }


            if (isiTabel.indexOf(kodebarang) !== -1) {
                // alert('Produk Sudah Ada, Silahkan Tambah Total Barang');
                alert('Produk Sudah Ada, Silahkan Tambah Total Barang');
            }
            if (isiTabel.indexOf(kodebarang) === -1) {

                tambahBarang();


            }


        }
        $("#dynamictable").on('click', '.btnDelete', function() {
            $(this).closest('tr').remove();
        });
        // calc_total();

        $("#dynamictable").on('change', '.totalBarang', function() {

            var parent = $(this).closest('tr');
            var price = parseFloat($('.harga', parent).text());
            var choose = parseFloat($('.totalBarang', parent).val());
            console.log(price);
            console.log(choose);
            $('.total', parent).text(choose * price);

            calc_total();
        });

        function calc_total() {
            var sum = 0;
            $(".total").each(function() {
                sum += parseFloat($(this).text());
            });
            // $('#totalharga"').text(sum);

        }
        $(document).ready(function() {
            // Event handler untuk event DOMSubtreeModified pada elemen table
            $('#dynamictable').on('DOMSubtreeModified', function() {
                // Inisialisasi variabel penjumlahan
                var totalHarga = 0;
                var tdElements = document.querySelectorAll('#dynamictable td span.total');

                // Loop melalui semua elemen td
                for (var i = 0; i < tdElements.length; i++) {
                    // Dapatkan nilai dari elemen span
                    var value = parseInt(tdElements[i].textContent);

                    // Atau, gunakan innerHTML jika Anda ingin mengambil data dari elemen span dalam bentuk HTML
                    // var value = tdElements[i].innerHTML;

                    // Tampilkan nilai elemen span
                    totalHarga += value;

                }
                document.getElementById("totalharga").innerHTML = totalHarga;

            });
        });


        function sum() {
            var totalHarga = 0;
            var tdElements = document.querySelectorAll('#dynamictable td span.total');

            // Loop melalui semua elemen td
            for (var i = 0; i < tdElements.length; i++) {
                // Dapatkan nilai dari elemen span
                var value = parseInt(tdElements[i].textContent);

                // Atau, gunakan innerHTML jika Anda ingin mengambil data dari elemen span dalam bentuk HTML
                // var value = tdElements[i].innerHTML;

                // Tampilkan nilai elemen span
                totalHarga += value;

            }
            document.getElementById("totalharga").innerHTML = totalHarga;
            // console.log(totalHarga);


            // var tableTotal = document.getElementById("dynamictable"),
            //     sumVal = 0;
            // // var totalBarang = document.getElementById("totalBarang").value;
            // // var totalBarang = $('#totalBarang').val();

            // for (var i = 1; i < tableTotal.rows.length; i++) {
            //     sumVal = sumVal + parseInt(tableTotal.rows[i].cells[5].innerHTML);
            //     // console.log(sumVal);
            // }
            // var totalHarga = sumVal * totalBarang;

            // console.log(sumVal);
            // console.log(totalBarang);

        }
        $(document).ready(function() {
            $("#uang").change(function() {
                document.getElementById("kembalian").innerHTML = parseInt($("#uang").val()) - parseInt($(
                    "#totalharga").text());
            });
        });

        function proses() {
            // var table = document.getElementById("dynamictable");

            // // Buat array kosong untuk menyimpan isi baris tabel
            // var rows = [];

            // // Loop melalui setiap baris tabel
            // for (var i = 1; i < table.rows.length; i++) {
            //     // Ambil baris saat ini
            //     var row = table.rows[i];

            //     // Buat array kosong untuk menyimpan isi sel dari baris saat ini
            //     var cells = [];

            //     // Loop melalui setiap sel dalam baris saat ini
            //     for (var j = 0; j < row.cells.length; j++) {
            //         // Ambil sel saat ini
            //         var cell = row.cells[j];

            //         // Tambahkan isi sel ke dalam array
            //         cells.push(cell.innerHTML);
            //     }

            //     // Tambahkan array sel ke dalam array baris
            //     rows.push(cells);
            // }
            // console.log(rows);
            // var table = $('#dynamictable').tableToJSON({
            //     ignoreColumns: [1, 2, 3, 5]



            // });
            // console.log(table);
            // Ambil element tabel
            var table = document.getElementById("dynamictable");

            // Ambil semua baris dari tabel, kecuali baris pertama (karena baris pertama adalah header tabel)
            var rows = table.querySelectorAll("tbody tr:not(:first-child)");

            // Buat objek untuk menyimpan data
            var data = {
                "data": []
            };

            // Loop melalui semua baris
            for (var i = 0; i < rows.length; i++) {
                // Ambil elemen-elemen yang diperlukan dari baris tersebut
                var kodeBarang = rows[i].querySelector(".kodebarang").textContent;
                var jumlah = rows[i].querySelector(".totalBarang").value;

                // Tambahkan data ke objek data
                data.data.push({
                    "barang_id": kodeBarang,
                    "jumlah": jumlah
                });
            }

            // Tampilkan objek data di console
            console.log(data);

            const csrfToken = document.head.querySelector("[name~=csrf-token][content]").content;


            Swal.fire({
                title: 'Apakah Data Sudah benar',
                text: 'Lanjutkan Transaksi ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    fetch('http://pblkasir.test/history-transaksi/transaksi', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                "X-CSRF-Token": csrfToken,
                            },
                            body: JSON.stringify(data),
                        })
                        .then((response) => response.json())
                        .then((result) => {
                            console.log(result);
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Data berhasil disimpan',
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonText: 'OK',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.value) {
                                    window.location.reload();
                                }
                            });
                        })
                        .catch((error) => {
                            console.error(error);
                            // tampilkan pesan error di sini
                        });
                }
            });
            // fetch('http://pblkasir.test/history-transaksi/transaksi', {
            //         method: 'POST',
            //         headers: {
            //             'Content-Type': 'application/json',
            //             "X-CSRF-Token": csrfToken,

            //         },
            //         body: JSON.stringify(data),
            //     })
            //     .then((response) => response.json())
            //     .then((result) => {

            //         // console.log(result);
            //         // alert('Data berhasil disimpan');
            //         console.log(result);
            //         Swal.fire({
            //             title: 'Berhasil',
            //             text: 'Data berhasil disimpan',
            //             icon: 'success',
            //             showCancelButton: false,
            //             confirmButtonText: 'OK',
            //             allowOutsideClick: false
            //         }).then((result) => {
            //             if (result.value) {
            //                 window.location.reload();
            //             }
            //         });

            //     })
            //     .catch((error) => {
            //         console.error(error);
            //         // tampilkan pesan error di sini
            //     });

        }
    </script>
@endsection
