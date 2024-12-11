<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use App\Models\TransaksiPenjualan;

class DashboardController extends Controller
{
    public function index(){
        $transaksi = TransaksiPenjualan::count();
        $jenis_barang = JenisBarang::where('status', true)->count();
        $barang = Barang::where('status', true)->count();

        $transaksi_report = TransaksiPenjualan::select('transaksi_penjualan.*', 'barang.nama AS nama_barang')
        ->leftJoin('barang', 'barang.id', '=', 'transaksi_penjualan.barang_id')
        ->get();

        $dataBarang = [];

        foreach ($transaksi_report as $data) {
            $barangName = $data->nama_barang; 

            if (!isset($dataBarang[$barangName])) {
                $dataBarang[$barangName] = 0;
            }

            $dataBarang[$barangName]++; 
        }

        $chartData = [
            'labels' => array_keys($dataBarang),
            'data' => array_values($dataBarang),
        ];

        return view('dashboard', compact('transaksi', 'jenis_barang', 'barang', 'chartData'));
      }
}
