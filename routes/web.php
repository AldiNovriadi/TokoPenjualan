<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\TransaksiPenjualanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return redirect()->route('index');
    
});

Route::get('/login', [AuthController::class, 'index'])->name('index');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => 'auth:web'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/jenis-barang', [JenisBarangController::class, 'index'])->name('jenis-barang');
    Route::get('/jenis-barang/getData', [JenisBarangController::class, 'getData'])->name('jenis-barang.getData');
    Route::get('/jenis-barang/add', [JenisBarangController::class, 'add'])->name('jenis-barang.add');
    Route::post('/jenis-barang/save', [JenisBarangController::class, 'save'])->name('jenis-barang.save');
    Route::get('/jenis-barang/edit/{id}', [JenisBarangController::class, 'edit'])->name('jenis-barang.edit');
    Route::get('/jenis-barang/detail/{id}', [JenisBarangController::class, 'detail'])->name('jenis-barang.detail');
    Route::put('/jenis-barang/update/{id}', [JenisBarangController::class, 'update'])->name('jenis-barang.update');
    Route::delete('/jenis-barang/delete', [JenisBarangController::class, 'delete'])->name('jenis-barang.delete');

    Route::get('/barang', [BarangController::class, 'index'])->name('barang');
    Route::get('/barang/getData', [BarangController::class, 'getData'])->name('barang.getData');
    Route::get('/barang/getDataJenisBarang', [BarangController::class, 'getDataJenisBarang'])->name('barang.getDataJenisBarang');
    Route::get('/barang/add', [BarangController::class, 'add'])->name('barang.add');
    Route::post('/barang/save', [BarangController::class, 'save'])->name('barang.save');
    Route::get('/barang/edit/{id}', [BarangController::class, 'edit'])->name('barang.edit');
    Route::get('/barang/detail/{id}', [BarangController::class, 'detail'])->name('barang.detail');
    Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/delete', [BarangController::class, 'delete'])->name('barang.delete');

    Route::get('/transaksi-penjualan', [TransaksiPenjualanController::class, 'index'])->name('transaksi-penjualan');
    Route::get('/transaksi-penjualan/getData', [TransaksiPenjualanController::class, 'getData'])->name('transaksi-penjualan.getData');
    Route::get('/transaksi-penjualan/getDataJenisBarang', [TransaksiPenjualanController::class, 'getDataJenisBarang'])->name('transaksi-penjualan.getDataJenisBarang');
    Route::get('/transaksi-penjualan/getDataBarang', [TransaksiPenjualanController::class, 'getDataBarang'])->name('transaksi-penjualan.getDataBarang');
    Route::get('/transaksi-penjualan/getDataJenisBarangIndex', [TransaksiPenjualanController::class, 'getDataJenisBarangIndex'])->name('transaksi-penjualan.getDataJenisBarangIndex');
    Route::get('/transaksi-penjualan/getDataBarangIndex', [TransaksiPenjualanController::class, 'getDataBarangIndex'])->name('transaksi-penjualan.getDataBarangIndex');
    Route::get('/transaksi-penjualan/add', [TransaksiPenjualanController::class, 'add'])->name('transaksi-penjualan.add');
    Route::post('/transaksi-penjualan/save', [TransaksiPenjualanController::class, 'save'])->name('transaksi-penjualan.save');
    Route::get('/transaksi-penjualan/edit/{id}', [TransaksiPenjualanController::class, 'edit'])->name('transaksi-penjualan.edit');
    Route::get('/transaksi-penjualan/detail/{id}', [TransaksiPenjualanController::class, 'detail'])->name('transaksi-penjualan.detail');
    Route::put('/transaksi-penjualan/update/{id}', [TransaksiPenjualanController::class, 'update'])->name('transaksi-penjualan.update');
    Route::delete('/transaksi-penjualan/delete', [TransaksiPenjualanController::class, 'delete'])->name('transaksi-penjualan.delete');


});

// Route::get('/', function () {
//     return view('welcome');
// });
