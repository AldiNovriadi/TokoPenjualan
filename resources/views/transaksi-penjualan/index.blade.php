@extends('layouts.main')

@section('content')
<div class="pagetitle">
<h1>Transaksi Penjualan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('transaksi-penjualan') }}">Transaksi Penjualan</a></li>
        </ol>
    </nav>
</div>

<section class="section dashboard">
    <div class="row">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card info-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex float-end gap-2">
                                <button type="button" id="btn_filter" class="btn btn-primary label-button-master my-3">
                                    <i class="bi bi-filter"></i> Filter Data
                                </button>
                                <a href="{{ route('transaksi-penjualan.add') }}" class="btn btn-primary label-button-master my-3">
                                    <i class="bi bi-plus"></i> Tambah Data
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3" id="filter_section" style="display: none;">
                        <div class="col-md-12">
                            <form id="filter_form">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-9 pt-3">
                                                <div class="form-group fv-row">
                                                    <label class="required form-label">Jenis Barang</label>
                                                    <input type="text" id="nama_jenis_barang" name="nama_jenis_barang" class="form-control mb-2" placeholder="Pilih Jenis Barang" readonly/>
                                                    <input type="hidden" id="jenis_barang_id" name="jenis_barang_id"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3 pt-3">
                                                <div class="fv-row">
                                                    <label class="form-label">&nbsp;</label>
                                                    <div class="form-group mb-2">
                                                        <button type="button" class="btn btn-primary" id="triggerJenisBarang"><i class="bi bi-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-9 pt-3">
                                                <div class="form-group fv-row">
                                                    <label class="required form-label">Barang</label>
                                                    <input type="text" id="nama_barang" name="nama_barang" class="form-control mb-2" placeholder="Pilih Barang" readonly/>
                                                    <input type="hidden" id="barang_id" name="barang_id"/>
                                                </div>
                                            </div>
                                            <div class="col-md-3 pt-3">
                                                <div class="fv-row">
                                                    <label class="form-label">&nbsp;</label>
                                                    <div class="form-group mb-2">
                                                        <button type="button" class="btn btn-primary" id="triggerBarang"><i class="bi bi-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-md-12">
                                            <div class="d-flex gap-1 float-end">
                                                <button type="reset" id="reset-btn" class="btn btn-danger text-white">Reset</button>
                                                <button class="btn btn-primary">Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <input type="text" id="searchdatatable" class="form-control form-control-solid form-control-sm w-25 ps-14 ms-auto" placeholder="Search" />
                    <table class="table table-bordered" id="data-table" width="100%">
                        <thead class="table-primary">
                            <tr>
                                <th width="10px">No</th>
                                <th> Tanggal Transaksi</th>
                                <th> Jenis Barang</th>
                                <th> Nama Barang</th>
                                <th> Jumlah </th>
                                <th width="250px"> Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
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
</section>
@endsection

@push('scripts')
{{-- <script src="/assets/js/transaksi-penjualan.js"></script> --}}
<script>
    $(document).ready(function() {

        $('#btn_filter').on('click', function(){
            $('#filter_section').slideToggle();
        });

        setTimeout(function(){
            $("div.alert").fadeOut(300, function(){ $(this).remove();});
        }, 5000);

        var data_index = $('#data-table').DataTable({
            "oLanguage": {
                "oPaginate": {
                    "sFirst": "<i class='ti-angle-left'></i>",
                    "sPrevious": "&#8592;",
                    "sNext": "&#8594;",
                    "sLast": "<i class='ti-angle-right'></i>"
                }
            },
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ route('transaksi-penjualan.getData') }}",
                dataType: "JSON",
                type: "GET",
                data:function(d){
                    d.jenis_barang_id = getJenisBarang();
                    d.barang_id = getBarang();
                }
            },
            columns: [
                {
                    data: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                { 
                    data: 'created_at',
                    name: 'created_at',
                    render:function(data){
                        return moment(data).format('DD-MM-YYYY');
                    }
                },
                { data: 'nama_jenis_barang', name: 'nama_jenis_barang' },
                { data: 'nama_barang', name: 'nama_barang' },
                {
                    data: 'jumlah',
                    mRender : function(data, type, row, meta) {
                        return meta.settings.fnFormatNumber(row.jumlah);
                    }
                },
                { data: 'action', name: 'action', className: 'text-center', 'searchable': false},
            ]
        });

        $('#searchdatatable').keyup(function() {
            data_index.search($(this).val()).draw();
        });

        $('#filter_form').submit(function(e) {
            e.preventDefault();
            data_index.search($("#searchdatatable").val()).draw();
        });

        function getJenisBarang(){
            return $("#jenis_barang_id").val();
        }

        function getBarang(){
            return $("#barang_id").val();
        }

        $('#reset-btn').on('click', function(){
            $("#jenis_barang_id").val('');
            $("#barang_id").val('');
        });

        $(document).on('click', '.delete', function(event) {
            var ix = $(this).data('ix');
            Swal.fire({
                html: 'Apakah anda yakin ingin menghapus data ini?',
                icon: "info",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "Ya, saya yakin!",
                cancelButtonText: 'Tidak, batalkan',
                customClass: {
                    confirmButton: "btn btn-primary me-2",
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('transaksi-penjualan.delete') }}",
                        data: ({
                            "_token": "{{ csrf_token() }}",
                            "_method": 'DELETE',
                            ix: ix,

                        }),
                        success: function() {
                            Swal.fire('Deleted!', 'Data berhasil dihapus',
                                'success');
                                data_index.ajax.reload(null, false);
                        }
                    });

                }
            });
        });

        $('#triggerJenisBarang').off().on('click', function() {
            getJenisBarang();
            $('#daftarData-jenisBarang').modal('show');
        });

        function getJenisBarang() {
            $("#table-jenisBarang").DataTable().destroy();
            $('#table-jenisBarang tbody').remove();
            $('#table-jenisBarang').DataTable({
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": "<i class='ti-angle-left'></i>",
                        "sPrevious": "&#8592;",
                        "sNext": "&#8594;",
                        "sLast": "<i class='ti-angle-right'></i>"
                    }
                },
                order: [[1, 'ASC']],
                processing: true,
                serverSide: true,
                pageLength : 5,
                lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
                ajax: {
                    url: "/transaksi-penjualan/getDataJenisBarangIndex",
                    dataType: "JSON",
                    type: "GET",
                    data: {
                        datatable: true,
                    },
                },
                columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true,
                        'selectAll': false
                    }
                }
                ],
                select: {
                    'style': 'single'
                },
                columns: [
                    { data: 'id'},
                    { data: 'nama', name: 'nama' },
                ],
            });

            var table_jenis_barang = $('#table-jenisBarang').DataTable();

            $('#selectData-jenisBarang').off().on('click', function(e) {
                var rows_selected = $(table_jenis_barang.$('input[type="checkbox"]:checked').map(function() {
                    return $(this).closest('tr');
                }));

                $.each(rows_selected, function() {
                    var data = table_jenis_barang.row(this).data();

                    $("#jenis_barang_id").val(data.id);
                    $("#nama_jenis_barang").val(data.nama);
                });

                $('#daftarData-jenisBarang').modal('hide');

                // Prevent actual form submission
                e.preventDefault();
            });

            $('#searchdatatableJenisBarang').keyup(function() {
                table_jenis_barang.search($(this).val()).draw();
            })
        }
    });

    $('#triggerBarang').off().on('click', function() {
            var jenis_barang_id = $("#jenis_barang_id").val();

            if(jenis_barang_id == ''){
                Swal.fire('Warning!', 'Pilih jenis barang terlebih dahulu.', 'warning');
                return false;
            }

            getBarang(jenis_barang_id);
            $('#daftarData-barang').modal('show');
        });

        function getBarang(jenis_barang_id) {
            $("#table-barang").DataTable().destroy();
            $('#table-barang tbody').remove();
            $('#table-barang').DataTable({
                "oLanguage": {
                    "oPaginate": {
                        "sFirst": "<i class='ti-angle-left'></i>",
                        "sPrevious": "&#8592;",
                        "sNext": "&#8594;",
                        "sLast": "<i class='ti-angle-right'></i>"
                    }
                },
                order: [[1, 'ASC']],
                processing: true,
                serverSide: true,
                pageLength : 5,
                lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
                ajax: {
                    url: "/transaksi-penjualan/getDataBarangIndex",
                    dataType: "JSON",
                    type: "GET",
                    data: {
                        datatable: true,
                        jenis_barang_id: jenis_barang_id
                    },
                },
                columnDefs: [
                {
                    'targets': 0,
                    'checkboxes': {
                        'selectRow': true,
                        'selectAll': false
                    }
                }
                ],
                select: {
                    'style': 'single'
                },
                columns: [
                    { data: 'id'},
                    { data: 'nama', name: 'nama' },
                ],
            });

            var table_barang = $('#table-barang').DataTable();

            $('#selectData-barang').off().on('click', function(e) {
                var rows_selected = $(table_barang.$('input[type="checkbox"]:checked').map(function() {
                    return $(this).closest('tr');
                }));

                $.each(rows_selected, function() {
                    var data = table_barang.row(this).data();

                    $("#barang_id").val(data.id);
                    $("#nama_barang").val(data.nama);
                    $("#stock").val(data.stok);
                });

                $('#daftarData-barang').modal('hide');

                // Prevent actual form submission
                e.preventDefault();
            });

            $('#searchdatatableBarang').keyup(function() {
                table_barang.search($(this).val()).draw();
            })
        }
</script>
@endpush