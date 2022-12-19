@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 bg-white">

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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangs as $barang)
                            <tr>

                                <td>{{ $barang->barang_id }}</td>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->harga_jual }}</td>
                                <td>{{ $barang->stok ?? '' }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4 bg-white">
            <div class="card">
                <div class="card-body">
                    asd
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
@endsection
