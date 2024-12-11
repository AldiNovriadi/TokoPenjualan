<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Barang;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    public function index(){
        return view("barang.index");
    }

    public function getData(){
        $query = Barang::select('barang.*', 
            DB::raw("CASE WHEN barang.status = true THEN 'Aktif' ELSE 'Tidak Aktif' END as status_label"),
            'jenis_barang.nama AS nama_jenis_barang'
        )->leftJoin('jenis_barang', 'jenis_barang.id', '=', 'barang.jenis_barang_id');

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
                
                $btn .= '<a href="'.route('barang.detail',$row->id).'" class="btn btn-success btn-sm me-3 label-button-crud">
                    Detail
                </a>';

                $btn .= '<a href="'.route('barang.edit',$row->id).'" class="btn btn-primary btn-sm me-3 label-button-crud">
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

    public function add(){
        return view('barang.add');
    }

    public function save(Request $request){

        if(!$request->has('status')){
            $status = 0 ;
        }else{
            $status = 1 ;
        }

        $data = Barang::create([
    		'jenis_barang_id'   => $request->jenis_barang_id,
    		'nama'              => $request->nama,
    		'stok'              => str_replace(',', '', $request->stok),
            'status'            => $status
    	]);

    	return redirect('/barang')->with(['success' => 'Data berhasil di simpan.']);
    }

    public function edit($id){
        $data = Barang::select('barang.*', 'jenis_barang.nama AS nama_jenis_barang')
            ->leftJoin('jenis_barang', 'jenis_barang.id', '=', 'barang.jenis_barang_id')
            ->where('barang.id', $id)
            ->first();
        
        return view('barang.edit', compact('data'));
    }

    public function update($id, Request $request){

        if(!$request->has('status')){
            $status = 0 ;
        }else{
            $status = 1 ;
        }

        $data = Barang::find($id);
        $data->jenis_barang_id = $request->jenis_barang_id;
        $data->nama = $request->nama;
        $data->stok = str_replace(',', '', $request->stok);
        $data->status = $status;
        $data->save();

        return redirect('/barang')->with(['success' => 'Data berhasil di update.']);
    }

    public function detail($id){
        $data = Barang::select('barang.*', 'jenis_barang.nama AS nama_jenis_barang')
        ->leftJoin('jenis_barang', 'jenis_barang.id', '=', 'barang.jenis_barang_id')
        ->where('barang.id', $id)
        ->first();

        return view('barang.detail', compact('data'));
    }

    public function delete(Request $request){
        $data = Barang::destroy($request->ix);

        return response()->json($data);
    }
}
