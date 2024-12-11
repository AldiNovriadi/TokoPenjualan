@extends('layouts.main')

@section('content')
<div class="pagetitle">
    <h1>Transaksi Penjualan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('transaksi-penjualan') }}">Transaksi Penjualan</a></li>
            <li class="breadcrumb-item active">Edit Data</li>
        </ol>
    </nav>
</div>

<div class="row">
    <form class="form d-flex flex-column flex-lg-row" id="form-add" method="post" enctype="multipart/form-data" action="{{ route('transaksi-penjualan.update', $data->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" id="id" value="{{ $data->id }}">
        <div class="col-md-12">
            <div class="card info-card">
                <div class="card-header">
                    <div class="card-title py-0 my-0 ">
                        <h5 style="margin-bottom:0px;">Edit Data</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row pt-3">
                        <div class="col-md-6 mb-10">
                            <div class="fv-row">
                                <label class="required form-label">Jenis Barang <span class="required"> *</span> </label>
                                <input type="text" name="nama_jenis_barang" id="nama_jenis_barang" class="form-control mb-2" placeholder="Jenis Barang" value="{{ $data->nama_jenis_barang }}" readonly/>
                                <input type="hidden" name="jenis_barang_id" id="jenis_barang_id" value="{{ $data->jenis_barang_id }}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="fv-row">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-group mb-2">
                                    <button type="button" class="btn btn-primary" id="triggerJenisBarang"><i class="bi bi-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-md-6 mb-10">
                            <div class="fv-row">
                                <label class="required form-label">Barang <span class="required"> *</span> </label>
                                <input type="text" name="nama_barang" id="nama_barang" class="form-control mb-2" placeholder="Barang" value="{{ $data->nama_barang }}" readonly/>
                                <input type="hidden" name="barang_id" id="barang_id" value="{{ $data->barang_id }}">
                                <input type="hidden" name="stock" id="stock" value="{{ $data->stok }}">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="fv-row">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-group mb-2">
                                    <button type="button" class="btn btn-primary" id="triggerBarang"><i class="bi bi-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-md-6 mb-10 fv-row">
                            <label class="required form-label">Jumlah <span class="required"> * </span></label>
                            <input type="text" name="jumlah" id="jumlah" class="form-control mb-2 format-number withseparator" placeholder="Jumlah" value="{{ number_format($data->jumlah, 0) }}" />
                            <input type="hidden" name="jumlah_sebelumnya" id="jumlah_sebelumnya" value="{{ $data->jumlah }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('transaksi-penjualan') }}" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-4">Batal</a>
                        <button type="submit" id="kt_ecommerce_add_category_submit" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                        </button>
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

<div class="modal fade" id="daftarData-barang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-title">
                    <input type="text" id="searchdatatableBarang" class="form-control form-control-solid form-control-sm w-25 ps-14 ms-auto" placeholder="Search" />
                </div>
                <table class="table table-bordered" id="table-barang" width="100%">
                    <thead class="table-primary">
                        <tr>
                            <th></th>
                            <th>Nama</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="selectData-barang">Select Data</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
	<script src="/assets/js/transaksi-penjualan.js"></script>
@endpush