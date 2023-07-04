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

class GudangController extends Controller
{
    public function index(){
        $data['title'] = "Staff";
        $data['nama'] = Auth::user()->name;
        return view('Gudang/index',$data);
    }

    public function dataProduct(){
        $data['title'] = "Data Barang";
        $data['nama'] = Auth::user()->name;
        $data['product'] = Product::all();
        $data['supplier'] = User::where('role',3)->get();
        return view('Gudang/dataProducts',$data);
    }

    public function dataMasuk(){
        $data['title'] = "Barang Masuk";
        $data['nama'] = Auth::user()->name;
        $data['product'] = HistoryProduct::where('user_id',Auth::user()->id)->where('status','Masuk')->get();
        return view('Gudang/dataMasuk',$data);
    }
    public function dataKeluar(){
        $data['title'] = "Barang Keluar";
        $data['nama'] = Auth::user()->name;
        $data['product'] = HistoryProduct::where('user_id',Auth::user()->id)->where('status','Keluar')->get();
        return view('Gudang/dataKeluar',$data);
    }
    public function addProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            $namafoto = "Gambar"."  ".$request->name." ".date("Y-m-d H-i-s");
            $extention = $request->file('gambar')->extension();
            $photo = sprintf('%s.%0.8s', $namafoto, $extention);
            $destination = base_path() .'/public/gambar';
            $request->file('gambar')->move($destination,$photo);

            $product = New Product;
            $product->name = $request->name;
            $product->stok = null;
            $product->gambar = $photo;
            $product->created_at = date("Y-m-d H:i:s");
            $product->updated_at = date("Y-m-d H:i:s");
            $product->save();

            DB::commit();
            \Session::flash('msg_success','Data Barang Berhasil Ditambah!');
            return Redirect::route('staff.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('staff.product');
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
            return Redirect::route('staff.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('staff.product');
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
            return Redirect::route('staff.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('staff.product');
        }
    }
    public function transaksi(Request $request)
    {
        
        DB::beginTransaction();
        try {

            if ($request->status == 'Keluar') {
                if ($request->jumlah > $request->stok) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok!');
                    return Redirect::route('staff.product');
                }

                if ($request->stok <= 0) {
                    \Session::flash('msg_error','Jumlah Barang Tidak Boleh Lebih dari Stok!');
                    return Redirect::route('staff.product');
                }

                $history = New HistoryProduct;
                $history->product_id = $request->id;
                $history->user_id = Auth::user()->id;
                $history->supplier_id = $request->supplier;
                $history->status = $request->status;
                $history->jumlah = $request->jumlah;
                $history->satuan = $request->satuan;
                $history->harga = $request->harga;
                $history->notes = $request->notes;
                $history->created_at = date("Y-m-d H:i:s");
                $history->updated_at = date("Y-m-d H:i:s");
                $history->save();

                $barang = Product::find($request->id);
                $barang->stok = $barang->stok - $request->jumlah;
                $barang->save();
            }elseif ($request->status == 'Masuk') {
                $history = New HistoryProduct;
                $history->product_id = $request->id;
                $history->user_id = Auth::user()->id;
                $history->supplier_id = $request->supplier;
                $history->status = $request->status;
                $history->jumlah = $request->jumlah;
                $history->satuan = $request->satuan;
                $history->harga = $request->harga;
                $history->notes = $request->notes;
                $history->created_at = date("Y-m-d H:i:s");
                $history->updated_at = date("Y-m-d H:i:s");
                $history->save();

                $barang = Product::find($request->id);
                $barang->stok = $barang->stok + $request->jumlah;
                $barang->save();
            }

            DB::commit();
            \Session::flash('msg_success','Berhasil Melakukan Transaksi!');
            return Redirect::route('staff.product');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('staff.product');
        }
    }
    public function print(Request $request)
    {
        $laporan = HistoryProduct::where('product_id',$request->id)->whereBetween('created_at', [$request->tanggalAwal, $request->tanggalAkhir])->get();
        $first = HistoryProduct::where('product_id',$request->id)->whereBetween('created_at', [$request->tanggalAwal, $request->tanggalAkhir])->first();
        $product = Product::where('id',$request->id)->first();
        // return $laporan;
        $pdf = Pdf::loadView('Gudang.laporan',compact('laporan','product','first'));
        return $pdf->stream();
    }
    public function hapusHistoryMasuk($id)
    {
        DB::beginTransaction();
        try {
            $dataHistory = HistoryProduct::where('id',$id)->first();
            $product = Product::find($dataHistory->product_id);
            $product->stok = $product->stok - $dataHistory->jumlah;
            $product->save();

            HistoryProduct::where('id',$id)->delete();
            DB::commit();
            \Session::flash('msg_success','Data History Berhasil Dihapus!');
            return Redirect::route('staff.masuk');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('staff.masuk');
        }
    }
    public function hapusHistoryKeluar($id)
    {
        DB::beginTransaction();
        try {
            $dataHistory = HistoryProduct::where('id',$id)->first();
            $product = Product::find($dataHistory->product_id);
            $product->stok = $product->stok + $dataHistory->jumlah;
            $product->save();
            
            HistoryProduct::where('id',$id)->delete();
            DB::commit();
            \Session::flash('msg_success','Data History Berhasil Dihapus!');
            return Redirect::route('staff.keluar');

        } catch (Exception $e) {
            DB::rollback();
            \Session::flash('msg_error','Somethings Wrong!');
            return Redirect::route('staff.keluar');
        }
    }
}
