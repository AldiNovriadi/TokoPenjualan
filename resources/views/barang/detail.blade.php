@extends('layouts.main')

@section('content')
<div class="pagetitle">
    <h1>Barang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('barang') }}">Barang</a></li>
            <li class="breadcrumb-item active">Detail Data</li>
        </ol>
    </nav>
</div>

<div class="row">
    <form class="form d-flex flex-column flex-lg-row" id="form-add" method="post" enctype="multipart/form-data" action="{{ route('barang.update', $data->id) }}">
        @csrf
        @method('PUT')
        <div class="col-md-12">
            <div class="card info-card">
                <div class="card-header">
                    <div class="card-title py-0 my-0 ">
                        <h5 style="margin-bottom:0px;">Detail Data</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row pt-3">
                        <div class="col-md-6 mb-10">
                            <div class="fv-row">
                                <label class="required form-label">Jenis Barang <span class="required"> *</span> </label>
                                <input type="text" name="nama_jenis_barang" id="nama_jenis_barang" class="form-control mb-2" placeholder="Jenis Barang" value="{{ $data->nama_jenis_barang }}" disabled/>
                                <input type="hidden" name="jenis_barang_id" id="jenis_barang_id" value="{{ $data->jenis_barang_id }}" >
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="fv-row">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-group mb-2">
                                    <button type="button" class="btn btn-primary" id="triggerJenisBarang" disabled><i class="bi bi-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-md-6 mb-10 fv-row">
                            <label class="required form-label">Nama <span class="required"> * </span></label>
                            <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" value="{{ $data->nama }}" disabled/>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-md-6 mb-10 fv-row">
                            <label class="required form-label">Stock <span class="required"> * </span></label>
                            <input type="text" name="stok" class="form-control mb-2 format-number withseparator" placeholder="Stock" value="{{ number_format($data->stok, 0) }}" disabled/>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="mb-10 fv-row">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="status" name="status"  @if($data->status == 1) checked="checked" @endif disabled/>
                                <label class="form-check-label" for="status" id="labelstatus"> {{($data->status == 1) ? 'Aktif' : 'Tidak Aktif'}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('barang') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-4">Batal</a>
                        {{-- <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Modal Select --}}
<div class="modal fade" id="daftarData-jenisBarang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Jenis Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-title">
                    <input type="text" id="searchdatatableJenisBarang" class="form-control form-control-solid form-control-sm w-25 ps-14 ms-auto" placeholder="Search" />
                </div>
                <table class="table table-bordered" id="table-jenisBarang" width="100%">
                    <thead class="table-primary">
                        <tr>
                            <th></th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="selectData-jenisBarang">Select Data</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
	<script src="/assets/js/barang.js"></script>
@endpush