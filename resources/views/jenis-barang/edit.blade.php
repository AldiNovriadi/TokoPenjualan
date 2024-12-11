@extends('layouts.main')

@section('content')
<div class="pagetitle">
    <h1>Jenis Barang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('jenis-barang') }}">Jenis Barang</a></li>
            <li class="breadcrumb-item active">Edit Data</li>
        </ol>
    </nav>
</div>

<div class="row">
    <form class="form d-flex flex-column flex-lg-row" id="form-add" method="post" enctype="multipart/form-data" action="{{ route('jenis-barang.update', $data->id) }}">
        @csrf
        @method('PUT')
        <div class="col-md-12">
            <div class="card info-card">
                <div class="card-header">
                    <div class="card-title py-0 my-0 ">
                        <h5 style="margin-bottom:0px;">Edit Data</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row pt-3">
                        <div class="col-md-6 mb-10 fv-row">
                            <label class="required form-label">Nama <span class="required"> * </span></label>
                            <input type="text" name="nama" class="form-control mb-2" placeholder="Nama" value="{{ $data->nama }}" />
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="mb-10 fv-row">
                            <label class="form-label">Status</label>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="status" name="status"  @if($data->status == 1) checked="checked" @endif/>
                                <label class="form-check-label" for="status" id="labelstatus"> {{($data->status == 1) ? 'Aktif' : 'Tidak Aktif'}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('jenis-barang') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-4">Batal</a>
                        <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
	<script src="/assets/js/jenis-barang.js"></script>
@endpush