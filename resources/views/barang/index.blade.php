@extends('layouts.main')

@section('content')
<div class="pagetitle">
<h1>Barang</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('barang') }}">Barang</a></li>
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
                                <a href="{{ route('barang.add') }}" class="btn btn-primary label-button-master my-3">
                                    <i class="bi bi-plus"></i> Tambah Data
                                </a>
                            </div>
                        </div>
                    </div>
                    <input type="text" id="searchdatatable" class="form-control form-control-solid form-control-sm w-25 ps-14 ms-auto" placeholder="Search" />
                    <table class="table table-bordered" id="data-table" width="100%">
                        <thead class="table-primary">
                            <tr>
                                <th width="10px">No</th>
                                <th> Jenis Barang</th>
                                <th> Nama</th>
                                <th> Stock </th>
                                <th width="150px"> Status</th>
                                <th width="250px"> Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {

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
                url: "{{ route('barang.getData') }}",
                dataType: "JSON",
                type: "GET",
            },
            columns: [
                {
                    data: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                { data: 'nama_jenis_barang', name: 'nama_jenis_barang' },
                { data: 'nama', name: 'nama' },
                {
                    data: 'stok',
                    mRender : function(data, type, row, meta) {
                        return meta.settings.fnFormatNumber(row.stok);
                    }
                },
                { data: 'status_label', name: 'status_label' },
                { data: 'action', name: 'action', className: 'text-center', 'searchable': false},
            ]
        });

        $('#searchdatatable').keyup(function() {
            data_index.search($(this).val()).draw();
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
                        url: "{{ route('barang.delete') }}",
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
    });
</script>
@endpush