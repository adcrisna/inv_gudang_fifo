<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GudangController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::any('/', [LoginController::class, 'index'])->name('index');
Route::any('/proses_login', [LoginController::class, 'prosesLogin'])->name('login');
Route::any('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::prefix('owner')->middleware(['admin'])->group(function () {
        Route::any('/home', [AdminController::class, 'index'])->name('home.owner');
        Route::any('/profile', [AdminController::class, 'profile'])->name('profile.owner');
        Route::any('/edit', [AdminController::class, 'edit'])->name('edit.owner');

        Route::any('/staff', [AdminController::class, 'dataUsers'])->name('owner.staff');
        Route::any('/add', [AdminController::class, 'addUsers'])->name('add.staff');
        Route::any('/delete{id}', [AdminController::class, 'deleteUsers'])->name('delete.staff');
        Route::any('/update', [AdminController::class, 'updateUsers'])->name('update.staff');

        Route::any('/supplier', [AdminController::class, 'dataSupplier'])->name('owner.supplier');
        Route::any('/supplier/add', [AdminController::class, 'addSupplier'])->name('add.supplier');
        Route::any('/supplier/delete{id}', [AdminController::class, 'deleteSupplier'])->name('delete.supplier');
        Route::any('/supplier/update', [AdminController::class, 'updateSupplier'])->name('update.supplier');

        Route::any('/product', [AdminController::class, 'dataProduct'])->name('owner.product');
        Route::any('/tambahProduct', [AdminController::class, 'addProduct'])->name('add.product');
        Route::any('/hapusProduct{id}', [AdminController::class, 'deleteProduct'])->name('delete.product');
        Route::any('/ubahProduct', [AdminController::class, 'updateProduct'])->name('update.product');
        Route::any('/productTransaksi', [AdminController::class, 'transaksi'])->name('owner.transaksi');

        Route::any('/barang/masuk', [AdminController::class, 'dataMasuk'])->name('owner.masuk');
        Route::any('/barang/keluar', [AdminController::class, 'dataKeluar'])->name('owner.keluar');
        Route::any('/print', [AdminController::class, 'printHistory'])->name('owner.print');
        Route::any('/cetak', [AdminController::class, 'printProduct'])->name('owner.cetak');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('staff')->middleware(['gudang'])->group(function () {
        Route::any('/home', [GudangController::class, 'index'])->name('home.staff');

        Route::any('/barang', [GudangController::class, 'dataProduct'])->name('staff.product');
        Route::any('/tambahBarang', [GudangController::class, 'addProduct'])->name('tambah.product');
        Route::any('/hapusBarang{id}', [GudangController::class, 'deleteProduct'])->name('hapus.product');
        Route::any('/ubahBarang', [GudangController::class, 'updateProduct'])->name('ubah.product');

        Route::any('/transaksi', [GudangController::class, 'transaksi'])->name('staff.transaksi');
        Route::any('/riwayat/masuk', [GudangController::class, 'dataMasuk'])->name('staff.masuk');
        Route::any('/riwayat/keluar', [GudangController::class, 'dataKeluar'])->name('staff.keluar');
        Route::any('/riwayat/masuk/hapus{id}', [GudangController::class, 'hapusHistoryMasuk'])->name('staff.hapus.masuk');
        Route::any('/riwayat/keluar/hapus{id}', [GudangController::class, 'hapusHistoryKeluar'])->name('staff.hapus.keluar');

        Route::any('/laporan', [GudangController::class, 'print'])->name('staff.print');
    });
});