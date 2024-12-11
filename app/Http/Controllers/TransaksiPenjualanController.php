<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\TransaksiPenjualan;

class TransaksiPenjualanController extends Controller
{
    public function index(){
        return view("transaksi-penjualan.index");
    }

    public function getData(Request $request){
        $query = TransaksiPenjualan::select(
            'transaksi_penjualan.*', 
            'jenis_barang.nama AS nama_jenis_barang',
            'barang.nama AS nama_barang'
        )
        ->leftJoin('jenis_barang', 'jenis_barang.id', '=', 'transaksi_penjualan.jenis_barang_id')
        ->leftJoin('barang', 'barang.id', '=', 'transaksi_penjualan.barang_id');

        if(isset($request->jenis_barang_id)){
            $query->where('transaksi_penjualan.jenis_barang_id', $request->jenis_barang_id);
        }
        if(isset($request->barang_id)){
            $query->where('transaksi_penjualan.barang_id', $request->barang_id);
        }

        return DataTables::eloquent($query)
            ->filter(function($data){
                if(request()->has('search')){
                    $search = strtolower(request()->search['value']);
                    $data->where(function($dt) use ($search){
                        $dt->orWhere(DB::raw("LOWER(jenis_barang.nama)"), "like", "%".$search."%");
                        $dt->orWhere(DB::raw("LOWER(barang.nama)"), "like", "%".$search."%");
                        $dt->orWhere(DB::raw("(barang.stok)"), "like", "%".$search."%");
                        $dt->orWhere(DB::raw("LOWER(CASE WHEN barang.status = true THEN 'Aktif' ELSE 'Tidak Aktif' END)"), "like", "%".$search."%");
                    });
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = "";
                
                $btn .= '<a href="'.route('transaksi-penjualan.detail',$row->id).'" class="btn btn-success btn-sm me-3 label-button-crud">
                    Detail
                </a>';

                $btn .= '<a href="'.route('transaksi-penjualan.edit',$row->id).'" class="btn btn-primary btn-sm me-3 label-button-crud">
                    Edit
                </a>';

                $btn .= '<a href="#" data-ix="' . $row->id . '" class="btn btn-danger btn-sm delete label-button-crud">
                    Delete
                </a>';
                return $btn;
            })
            ->make(true);
    }

    public function getDataJenisBarang(){
        $query = JenisBarang::where('status', true);

        return Datatables::eloquent($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function getDataBarang(Request $request){
        $query = Barang::where('status', true)->where('stok', '!=', 0);

        if(isset($request->jenis_barang_id)){
            $query->where('jenis_barang_id', $request->jenis_barang_id);
        }

        return Datatables::eloquent($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function getDataJenisBarangIndex(){
        $query = JenisBarang::where('status', true);

        return Datatables::eloquent($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function getDataBarangIndex(Request $request){
        $query = Barang::where('status', true);

        if(isset($request->jenis_barang_id)){
            $query->where('jenis_barang_id', $request->jenis_barang_id);
        }

        return Datatables::eloquent($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function add(){
        return view('transaksi-penjualan.add');
    }

    public function save(Request $request){

        $data = TransaksiPenjualan::create([
    		'jenis_barang_id'   => $request->jenis_barang_id,
    		'barang_id'         => $request->barang_id,
    		'jumlah'            => str_replace(',', '', $request->jumlah),
    	]);

        // Mengurangi Stock di barang
        $barang = Barang::find($request->barang_id);
        if ($barang) {
            $barang->stok -= str_replace(',', '', $request->jumlah); 
            $barang->save(); 
        }

    	return redirect('/transaksi-penjualan')->with(['success' => 'Data berhasil di simpan.']);
    }

    public function edit($id){
        $data = TransaksiPenjualan::select(
            'transaksi_penjualan.*', 
            'jenis_barang.nama AS nama_jenis_barang',
            'barang.nama AS nama_barang',
            'barang.stok'
        )
        ->leftJoin('jenis_barang', 'jenis_barang.id', '=', 'transaksi_penjualan.jenis_barang_id')
        ->leftJoin('barang', 'barang.id', '=', 'transaksi_penjualan.barang_id')
        ->where('transaksi_penjualan.id', $id)
        ->first();

        return view('transaksi-penjualan.edit', compact('data'));
    }

    public function update($id, Request $request){

        $data = TransaksiPenjualan::find($id);

        $jumlahSebelumnya = $data->jumlah;

        $data->jenis_barang_id = $request->jenis_barang_id;
        $data->barang_id = $request->barang_id;
        $data->jumlah = str_replace(',', '', $request->jumlah);
        $data->save();

        if ($data->barang_id != $request->barang_id) {
            $barangLama = Barang::find($data->barang_id);
            if ($barangLama) {
                $barangLama->stok += $jumlahSebelumnya;
                $barangLama->save();
            }
        } else {
            $barang = Barang::find($data->barang_id);
            if ($barang) {
                $stokAdjustment = $jumlahSebelumnya - $data->jumlah;
                $barang->stok += $stokAdjustment;
                $barang->save();
            }
        }

        if ($data->barang_id != $request->barang_id) {
            $barangBaru = Barang::find($request->barang_id);
            if ($barangBaru) {
                $barangBaru->stok -= $data->jumlah;
                $barangBaru->save();
            }
        }

        return redirect('/transaksi-penjualan')->with(['success' => 'Data berhasil di update.']);
    }

    public function detail($id){
        $data = TransaksiPenjualan::select(
            'transaksi_penjualan.*', 
            'jenis_barang.nama AS nama_jenis_barang',
            'barang.nama AS nama_barang'
        )
        ->leftJoin('jenis_barang', 'jenis_barang.id', '=', 'transaksi_penjualan.jenis_barang_id')
        ->leftJoin('barang', 'barang.id', '=', 'transaksi_penjualan.barang_id')
        ->where('transaksi_penjualan.id', $id)
        ->first();

        return view('transaksi-penjualan.detail', compact('data'));
    }

    public function delete(Request $request){
        
        $transaksi = TransaksiPenjualan::find($request->ix);
        $barang = Barang::find($transaksi->barang_id);
        if ($barang) {
            $barang->stok += $transaksi->jumlah;
            $barang->save();
        }
        
        $data = TransaksiPenjualan::destroy($request->ix);
        return response()->json($data);
    }
}
