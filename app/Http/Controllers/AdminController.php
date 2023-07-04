<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\HistoryProduct;
use Redirect;
use Auth;
use DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HistoryExport;
use App\Exports\ProductExport;

class AdminController extends Controller
{
    public function index(){
        $data['title'] = "Admin";
        $data['nama'] = Auth::user()->name;
        $data['staff'] = User::where('role',2)->get();
        $data['supplier'] = User::where('role',3)->get();
        $data['barang'] = Product::all();
        return view('Admin/index',$data);
    }

    public function dataUsers(){
        $data['title'] = "Data Users";
        $data['nama'] = Auth::user()->name;
        $data['staff'] = User::where('role',2)->get();
        return view('Admin/dataUsers',$data);
    }
    public function addUsers(Request $request)
    {
        DB::beginTransaction();
        try {
            $cekData = User::where('kode',$request->kode)->first();
            if ($cekData) {
                \Session::flash('msg_error','ID Sudah Digunakan!');
            return Redirect::route('owner.staff');
            }
            $user = New User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->kode = $request->kode;
            $user->password = bcrypt($request->password);
            $user->phone = $request->phone;
            $user->alamat = $request->alamat;
            $user->role = 2;
            $user->created_at = date("Y-m-d H:i:s");
            $user->updated_at = date("Y-m-d H:i:s");
            $user->save();

            DB::commit();
            \Session::flash('msg_success','Data User Berhasil Ditambah!');
            return Redirect::route('owner.staff');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('owner.staff');
        }
    }
    public function updateUsers(Request $request)
    {
        DB::beginTransaction();
        try {
            if (empty($request->password)) {
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->alamat = $request->alamat;
                $user->role = 2;
                $user->updated_at = date("Y-m-d H:i:s");
                $user->save();
            }else{
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->phone = $request->phone;
                $user->alamat = $request->alamat;
                $user->role = 2;
                $user->updated_at = date("Y-m-d H:i:s");
                $user->save();
            }

            DB::commit();
            \Session::flash('msg_success','Data User Berhasil Diubah!');
            return Redirect::route('owner.staff');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('owner.staff');
        }
    }
    public function deleteUsers($id)
    {
        DB::beginTransaction();
        try {
            User::where('id',$id)->delete();
            DB::commit();
            \Session::flash('msg_success','Data User Berhasil Dihapus!');
            return Redirect::route('owner.staff');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('owner.staff');
        }
    }

    public function dataSupplier(){
        $data['title'] = "Data Supplier";
        $data['nama'] = Auth::user()->name;
        $data['supplier'] = User::where('role',3)->get();
        return view('Admin/dataSupplier',$data);
    }
    public function addSupplier(Request $request)
    {
        DB::beginTransaction();
        try {

            $cekData = User::where('kode',$request->kode)->first();
            if ($cekData) {
                \Session::flash('msg_error','ID Sudah Digunakan!');
            return Redirect::route('owner.supplier');
            }

            $user = New User;
            $user->name = $request->name;
            $user->kode = $request->kode;
            $user->email = $request->email;
            $user->password = null;
            $user->phone = $request->phone;
            $user->alamat = $request->alamat;
            $user->role = 3;
            $user->created_at = date("Y-m-d H:i:s");
            $user->updated_at = date("Y-m-d H:i:s");
            $user->save();

            DB::commit();
            \Session::flash('msg_success','Data User Berhasil Ditambah!');
            return Redirect::route('owner.supplier');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('owner.supplier');
        }
    }
    public function updateSupplier(Request $request)
    {
        DB::beginTransaction();
        try {
            
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->kode = $request->kode;
                $user->phone = $request->phone;
                $user->alamat = $request->alamat;
                $user->role = 3;
                $user->updated_at = date("Y-m-d H:i:s");
                $user->save();

            DB::commit();
            \Session::flash('msg_success','Data User Berhasil Diubah!');
            return Redirect::route('owner.supplier');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('owner.supplier');
        }
    }
    public function deleteSupplier($id)
    {
        DB::beginTransaction();
        try {
            User::where('id',$id)->delete();
            DB::commit();
            \Session::flash('msg_success','Data User Berhasil Dihapus!');
            return Redirect::route('owner.supplier');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('owner.supplier');
        }
    }

    public function dataProduct(){
        $data['title'] = "Data Barang";
        $data['nama'] = Auth::user()->name;
        $data['product'] = Product::all();
        return view('Admin/dataProducts',$data);
    }

    public function addProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            $cekData = Product::where('kode',$request->kode)->first();
            if ($cekData) {
                \Session::flash('msg_error','ID Sudah Digunakan!');
            return Redirect::route('owner.product');
            }
            $namafoto = "Gambar"."  ".$request->name." ".date("Y-m-d H-i-s");
            $extention = $request->file('gambar')->extension();
            $photo = sprintf('%s.%0.8s', $namafoto, $extention);
            $destination = base_path() .'/public/gambar';
            $request->file('gambar')->move($destination,$photo);

            $product = New Product;
            $product->name = $request->name;
            $product->kode = $request->kode;
            $product->stok = null;
            $product->gambar = $photo;
            $product->created_at = date("Y-m-d H:i:s");
            $product->updated_at = date("Y-m-d H:i:s");
            $product->save();

            DB::commit();
            \Session::flash('msg_success','Data Barang Berhasil Ditambah!');
            return Redirect::route('owner.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('owner.product');
        }
    }
    public function updateProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            if (empty($request->gambar)) {
                $product = Product::find($request->id);
                $product->name = $request->name;
                $product->stok = $request->stok;
                $product->created_at = date("Y-m-d H:i:s");
                $product->updated_at = date("Y-m-d H:i:s");
                $product->save();
            }else{
                $product = Product::find($request->id);

                \File::delete(public_path('gambar/'.$product->gambar));

                $namafoto = "Gambar"."  ".$request->name." ".date("Y-m-d H-i-s");
                $extention = $request->file('gambar')->extension();
                $photo = sprintf('%s.%0.8s', $namafoto, $extention);
                $destination = base_path() .'/public/gambar';
                $request->file('gambar')->move($destination,$photo);

                $product->name = $request->name;
                $product->stok = $request->stok;
                $product->gambar = $photo;
                $product->created_at = date("Y-m-d H:i:s");
                $product->updated_at = date("Y-m-d H:i:s");
                $product->save();
            }

            DB::commit();
            \Session::flash('msg_success','Data Barang Berhasil Diubah!');
            return Redirect::route('owner.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('owner.product');
        }
    }
    
    public function deleteProduct($id)
    {
        DB::beginTransaction();
        try {
            $getProduct = Product::where('id',$id)->first();
            \File::delete(public_path('gambar/'.$getProduct->gambar));
            $product = Product::where('id',$id)->delete();
            DB::commit();
            \Session::flash('msg_success','Data Barang Berhasil Dihapus!');
            return Redirect::route('owner.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('owner.product');
        }
    }

    public function transaksi(Request $request)
    {
        DB::beginTransaction();
        try {

            if ($request->status == 'Pengembalian') {
                $barang = Product::find($request->id);
                $cekStok = $barang->stok + $request->jumlah;
                if ($cekStok > $barang->stok_awal) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok Awal!');
                    return Redirect::route('admin.product');
                }
                $history = New HistoryProduct;
                $history->product_id = $request->id;
                $history->user_id = Auth::user()->id;
                $history->status = $request->status;
                $history->jumlah = $request->jumlah;
                $history->kondisi = $request->kondisi;
                $history->lokasi_id = $request->lokasi;
                $history->notes = $request->notes;
                $history->created_at = date("Y-m-d H:i:s");
                $history->updated_at = date("Y-m-d H:i:s");
                $history->save();

                
                $barang->stok = $barang->stok + $request->jumlah;
                $barang->save();
            }elseif ($request->status == 'Peminjaman') {
                if ($request->jumlah > $request->stok) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok!');
                    return Redirect::route('admin.product');
                }

                if ($request->stok <= 0) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok!');
                    return Redirect::route('admin.product');
                }

                $history = New HistoryProduct;
                $history->product_id = $request->id;
                $history->user_id = Auth::user()->id;
                $history->status = $request->status;
                $history->jumlah = $request->jumlah;
                $history->kondisi = $request->kondisi;
                $history->lokasi_id = $request->lokasi;
                $history->notes = $request->notes;
                $history->created_at = date("Y-m-d H:i:s");
                $history->updated_at = date("Y-m-d H:i:s");
                $history->save();

                $barang = Product::find($request->id);
                $barang->stok = $barang->stok - $request->jumlah;
                $barang->save();
            }elseif ($request->status == 'Keluar') {
                if ($request->jumlah > $request->stok) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok!');
                    return Redirect::route('owner.product');
                }

                if ($request->stok <= 0) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok!');
                    return Redirect::route('owner.product');
                }

                $history = New HistoryProduct;
                $history->product_id = $request->id;
                $history->user_id = Auth::user()->id;
                $history->status = $request->status;
                $history->jumlah = $request->jumlah;
                $history->kondisi = $request->kondisi;
                $history->lokasi_id = $request->lokasi;
                $history->notes = $request->notes;
                $history->created_at = date("Y-m-d H:i:s");
                $history->updated_at = date("Y-m-d H:i:s");
                $history->save();

                $barang = Product::find($request->id);
                $barang->stok = $barang->stok - $request->jumlah;
                $barang->stok_awal = $barang->stok_awal - $request->jumlah;
                $barang->save();
            }elseif ($request->status == 'Masuk') {
                $history = New HistoryProduct;
                $history->product_id = $request->id;
                $history->user_id = Auth::user()->id;
                $history->status = $request->status;
                $history->jumlah = $request->jumlah;
                $history->kondisi = $request->kondisi;
                $history->lokasi_id = $request->lokasi;
                $history->notes = $request->notes;
                $history->created_at = date("Y-m-d H:i:s");
                $history->updated_at = date("Y-m-d H:i:s");
                $history->save();

                $barang = Product::find($request->id);
                $barang->stok = $barang->stok + $request->jumlah;
                $barang->stok_awal = $barang->stok_awal + $request->jumlah;
                $barang->save();
            }

            DB::commit();
            \Session::flash('msg_success','Berhasil Melakukan Transaksi!');
            return Redirect::route('owner.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('owner.product');
        }
    }

    public function dataMasuk(){
        $data['title'] = "Data Barang Masuk";
        $data['nama'] = Auth::user()->name;
        $data['history'] = HistoryProduct::where('status','Masuk')->get();
        return view('Admin/dataMasuk',$data);
    }
    public function dataKeluar(){
        $data['title'] = "Data Barang Keluar";
        $data['nama'] = Auth::user()->name;
        $data['history'] = HistoryProduct::where('status','Keluar')->get();
        return view('Admin/dataKeluar',$data);
    }
    public function printHistory(Request $request)
    {
        return Excel::download(new HistoryExport($request->tanggalAwal, $request->tanggalAkhir), 'data_history_barang.xlsx');
    }
    public function printProduct(Request $request)
    {
        return Excel::download(new ProductExport($request->tanggalAwal, $request->tanggalAkhir), 'data_barang.xlsx');
    }
    public function profile()
    {
        $data['title'] = "Profile Admin";
        $data['nama'] = Auth::user()->name;
        $data['admin'] = User::find(Auth::user()->id);
        return view('Admin/profile',$data);
    }
    public function edit(Request $request)
    {
        
        DB::beginTransaction();
        try {
            if (empty($request->password)) {
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->save();
            }else {
                $user = User::find($request->id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = $request->phone;
                $user->password = bcrypt($request->password);
                $user->save();
            }
            DB::commit();
            \Session::flash('msg_success','Data Barang Berhasil Diubah!');
            return Redirect::route('profile.owner');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('profile.owner');
        }
    }
}
