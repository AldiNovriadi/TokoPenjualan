<?php

namespace App\Http\Controllers;

use DB;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class JenisBarangController extends Controller
{
    public function index(){
        return view("jenis-barang.index");
    }

    public function getData(){
        $query = JenisBarang::select('*', DB::raw("CASE WHEN status = true THEN 'Aktif' ELSE 'Tidak Aktif' END as status_label"));

        return DataTables::eloquent($query)
            ->filter(function($data){
                if(request()->has('search')){
                    $search = strtolower(request()->search['value']);
                    $data->where(function($dt) use ($search){
                        $dt->orWhere(DB::raw("LOWER(nama)"), "like", "%".$search."%");
                        $dt->orWhere(DB::raw("LOWER(CASE WHEN status = true THEN 'Aktif' ELSE 'Tidak Aktif' END)"), "like", "%".$search."%");
                    });
                }
            })
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = "";
                
                $btn .= '<a href="'.route('jenis-barang.detail',$row->id).'" class="btn btn-success btn-sm me-3 label-button-crud">
                    Detail
                </a>';

                $btn .= '<a href="'.route('jenis-barang.edit',$row->id).'" class="btn btn-primary btn-sm me-3 label-button-crud">
                    Edit
                </a>';

                $btn .= '<a href="#" data-ix="' . $row->id . '" class="btn btn-danger btn-sm delete label-button-crud">
                    Delete
                </a>';
                return $btn;
            })
            ->make(true);
    }

    public function add(){
        return view('jenis-barang.add');
    }

    public function save(Request $request){

        if(!$request->has('status')){
            $status = 0 ;
        }else{
            $status = 1 ;
        }

        $data = JenisBarang::create([
    		'nama'      => $request->nama,
            'status'    => $status
    	]);

    	return redirect('/jenis-barang')->with(['success' => 'Data berhasil di simpan.']);
    }

    public function edit($id){
        $data = JenisBarang::find($id);
        return view('jenis-barang.edit', compact('data'));
    }

    public function update($id, Request $request){

        if(!$request->has('status')){
            $status = 0 ;
        }else{
            $status = 1 ;
        }

        $data = JenisBarang::find($id);
        $data->nama = $request->nama;
        $data->status = $status;
        $data->save();

        return redirect('/jenis-barang')->with(['success' => 'Data berhasil di update.']);
    }

    public function detail($id){
        $data = JenisBarang::find($id);
        return view('jenis-barang.detail', compact('data'));
    }

    public function delete(Request $request){
        $data = JenisBarang::destroy($request->ix);
        return response()->json($data);
    }
}
