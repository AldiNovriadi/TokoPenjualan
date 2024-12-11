<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $konsumsiId = DB::table('jenis_barang')->insertGetId([
            'nama' => 'Konsumsi',
            'status' => true,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $pembersihId = DB::table('jenis_barang')->insertGetId([
            'nama' => 'Pembersih',
            'status' => true,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        DB::table('barang')->insert([
            [
                'jenis_barang_id' => $konsumsiId, 
                'nama' => 'Kopi',
                'stok' => '100',
                'status' => true,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'jenis_barang_id' => $konsumsiId, 
                'nama' => 'Teh',
                'stok' => '50',
                'status' => true,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'jenis_barang_id' => $pembersihId, 
                'nama' => 'Pasta Gigi',
                'stok' => '150',
                'status' => true,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'jenis_barang_id' => $pembersihId, 
                'nama' => 'Sabun Mandi',
                'stok' => '200',
                'status' => true,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
