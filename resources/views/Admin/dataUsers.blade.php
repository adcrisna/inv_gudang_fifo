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
            <li class="active">Data Staff</li>
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
                        <h3 class="box-title">Data Staff</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-info btn-xs" data-toggle="modal"
                                data-target="#modal-form-tambah-gudang"><i class="fa fa-user-plus"> Tambah Data
                                </i></button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-bordered table-striped" id="data-gudang">
                            <thead>
                                <tr>
                                    <th style="display: none">ID</th>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (@$staff as $key => $value)
                                    <tr>

                                        <td style="display: none">{{ @$value->id }}</td>
                                        <td>{{ @$value->kode }}</td>
                                        <td>{{ @$value->name }}</td>
                                        <td>{{ @$value->email }}</td>
                                        <td>{{ @$value->phone }}</td>
                                        <td>{{ @$value->alamat }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-success btn-edit-gudang"><i class="fa fa-edit">
                                                    Ubah</i></button> &nbsp;
                                            <a href="{{ route('delete.staff', @$value->id) }}"><button
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
    <div class="modal fade" id="modal-form-tambah-gudang" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Tambah Data Staff</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('add.staff') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <label>ID :</label>
                            <input type="text" name="kode" class="form-control" placeholder="ID" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Nama :</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Email :</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>No Telpon :</label>
                            <input type="number" name="phone" class="form-control" placeholder="No Handphone" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Password :</label>
                            <input type="password" name="password" class="form-control" placeholder="Masukan Password"
                                required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Alamat :</label>
                            <textarea name="alamat" id="alamat" class="form-control" cols="10" rows="5"></textarea>
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
    <div class="modal fade" id="modal-form-edit-gudang" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Form Update Staff</h4>
                </div>
                <div class="modal-body">
                    <form action="{{ route('update.staff') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group has-feedback">
                            <label>ID :</label>
                            <input type="text" name="kode" class="form-control" placeholder="ID" readonly>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="hidden" name="id" readonly class="form-control" placeholder="ID"
                                required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Nama :</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Email :</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>No. Telpon :</label>
                            <input type="number" name="phone" class="form-control" placeholder="No Handphone"
                                required>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Password Baru :</label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Masukan Password Baru">
                        </div>
                        <div class="form-group has-feedback">
                            <label>Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" cols="10" rows="5"></textarea>
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
@endsection

@section('javascript')
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        var table = $('#data-gudang').DataTable();

        $('#data-gudang').on('click', '.btn-edit-gudang', function() {
            row = table.row($(this).closest('tr')).data();
            console.log(row);
            $('input[name=id]').val(row[0]);
            $('input[name=kode]').val(row[2]);
            $('input[name=name]').val(row[2]);
            $('input[name=email]').val(row[3]);
            $('input[name=phone]').val(row[4]);
            $('textarea[name=alamat]').val(row[5]);
            $('#modal-form-edit-gudang').modal('show');
        });
        $('#modal-form-tambah-gudang').on('show.bs.modal', function() {
            $('input[name=id]').val('');
            $('input[name=name]').val('');
            $('input[name=kode]').val('');
            $('input[name=email]').val('');
            $('input[name=phone]').val('');
            $('select[name=alamat]').val('');
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
