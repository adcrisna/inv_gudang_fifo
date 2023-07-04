@extends('layouts.admin')
@section('css')
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.css') }}">
    <style>
        img.zoom {
            width: 130px;
            height: 100px;
            -webkit-transition: all .2s ease-in-out;
            -moz-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            -ms-transition: all .2s ease-in-out;
        }

        .transisi {
            -webkit-transform: scale(1.8);
            -moz-transform: scale(1.8);
            -o-transform: scale(1.8);
            transform: scale(1.8);
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="{{ route('home.owner') }}"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Data Master Barang</li>
        </ol>
        <br />
    </section>
    <section class="content">
        @if (\Session::has('msg_success'))
            <h5>
                <div class="alert alert-info">
                    {{ \Session::get('msg_success') }}
                </div>
            </h5>
        @endif
        @if (\Session::has('msg_error'))
            <h5>
                <div class="alert alert-danger">
                    {{ \Session::get('msg_error') }}
                </div>
            </h5>
        @endif
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Data Barang</h3>
                        <div class="box-tools pull-right">
                            {{-- <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#exportModal"><i
                                    class="fa fa-download"></i>
                                Laporan</button> --}}
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                data-target="#modal-form-tambah-product"><i class="fa fa-plus"> Tambah Barang
                                </i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="data-product">
                            <thead>
                                <tr>
                                    <th style="display: none">ID</th>
                                    <th>ID Barang</th>
                                    <th>Gambar</th>
                                    <th>Nama</th>
                                    <th>Stok</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$product as $key => $value)
                                    <tr>
                                        <td style="display: none">{{ @$value->id }}</td>
                                        <td>{{ @$value->kode }}</td>
                                        <td><img class="zoom" src="{{ asset('gambar/' . @$value->gambar) }}"></td>
                                        <td>{{ @$value->name }}</td>
                                        <td>{{ @$value->stok }}</td>
                                        <td>{{ @$value->created_at }}</td>
                                        <td>
                                            {{-- <button class="btn btn-xs btn-primary btn-transaksi-product"><i
                                                    class="fa fa-edit">
                                                    In/Out</i></button> &nbsp; --}}
                                            <button class="btn btn-xs btn-success btn-edit-product"><i class="fa fa-edit">
                                                    Ubah</i></button> &nbsp;
                                            <a href="{{ route('delete.product', @$value->id) }}"><button
                                                    class=" btn btn-xs btn-danger"
                                                    onclick="return confirm('Apakah anda ingin menghapus data ini ?')"><i
                                                        class="fa fa-trash"> Hapus</i></button></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-form-tambah-product" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Tambah Data Barang</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add.product') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <label>ID Barang:</label>
                            <input type="text" name="kode" class="form-control" placeholder="ID" required>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" name="name" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Gambar Barang :</label>
                            <input type="file" name="gambar" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Export</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('owner.cetak') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group has-feedback">
                            <label>Tanggal Awal</label>
                            <input type="date" name="tanggalAwal" class="form-control" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="tanggalAkhir" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-form-edit-product" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Update Data Barang</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.product') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <input type="hiden" name="id" readonly class="form-control" placeholder="ID"
                                required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>ID Barang:</label>
                            <input type="text" name="kode" class="form-control" placeholder="ID" readonly>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Nama Barang :</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Stok :</label>
                            <input type="number" name="stok" min="0" class="form-control"
                                placeholder="Stok Barang" readonly>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Gambar Barang Baru:</label>
                            <input type="file" name="gambar" class="form-control">
                        </div>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-form-transaksi-product" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Barang Masuk/Keluar</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('owner.transaksi') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <input type="hidden" name="id" readonly class="form-control" placeholder="ID"
                                required>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group has-feedback">
                                    <label>Barang : </label>
                                    <input type="text" name="name" class="form-control" placeholder="Nama"
                                        readonly>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group has-feedback">
                                    <label>Stok : </label>
                                    <input type="number" name="stok" min="0" class="form-control"
                                        placeholder="Stok Barang" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group has-feedback">
                                    <label>Status Barang : </label>
                                    <select name="status" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="Keluar">Keluar</option>
                                        <option value="Masuk">Masuk</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group has-feedback">
                                    <label>Jumlah : </label>
                                    <input type="number" name="jumlah" min="1" class="form-control"
                                        placeholder="Jumlah Barang">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group has-feedback">
                                    <label>Harga Barang : </label>
                                    <input type="number" name="harga" class="form-control"
                                        placeholder="Harga Barang">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label for="notes">Notes</label>
                                <textarea name="notes" cols="10" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-4 col-xs-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        var table = $('#data-product').DataTable();

        $('#data-product').on('click', '.btn-edit-product', function() {
            row = table.row($(this).closest('tr')).data();
            console.log(row);
            $('input[name=id]').val(row[0]);
            $('input[name=kode]').val(row[1]);
            $('input[name=name]').val(row[3]);
            $('input[name=stok]').val(row[4]);
            $('#modal-form-edit-product').modal('show');
        });
        $('#data-product').on('click', '.btn-transaksi-product', function() {
            row = table.row($(this).closest('tr')).data();
            console.log(row);
            $('input[name=id]').val(row[0]);
            $('input[name=kode]').val(row[1]);
            $('input[name=name]').val(row[3]);
            $('input[name=stok]').val(row[4]);
            $('#modal-form-transaksi-product').modal('show');
        });
        $('#modal-form-tambah-product').on('show.bs.modal', function() {
            $('input[name=id]').val('');
            $('input[name=name]').val('');
            $('input[name=kode]').val('');
            $('input[name=stok]').val('');
            $('input[name=gambar]').val('');
        });

        $(document).ready(function() {
            $('.zoom').hover(function() {
                $(this).addClass('transisi');
            }, function() {
                $(this).removeClass('transisi');
            });
        });
    </script>
@endsection
