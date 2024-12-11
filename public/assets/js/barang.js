$(document).ready(function(){
    $('#form-add').validate({
        errorClass: "invalid-feedback",
        ignore: [],
        errorElement: 'div',
        validClass: "valid-feedback",
        rules: {
            nama_jenis_barang: {
                required: true,
            },
            nama: {
                required: true,
            },
            stok: {
                required: true,
            },
        },
        messages: {
            nama_jenis_barang: {
                required: "Silahkan pilih Jenis Barang",
            },
            nama: {
                required: "Silahkan mengisi Nama",
            },
            stok: {
                required: "Silahkan mengisi Stock",
            },
        },
        errorPlacement: function (error, element) {
            if (element.parent('.inline-form').length) {
                error.insertAfter(element.parent());
            }else if(element.parent('.input-group').length){
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        onError: function () {
            $('.input-group.error-class').find('.help-block.form-error').each(function () {
                $(this).closest('.inline-form').addClass('error-class').append($(this));
            });
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.inline-form').addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.inline-form').removeClass("has-error");
        }
    });

    $('#status').on('change', function(){
        if($(this).is(':checked')){
            $('label[for="status"]').text('Aktif');
        }else{
            $('label[for="status"]').text('Tidak Aktif');
        }
    });

    $("#submitForm").on("click", function(){
    	$(this).attr('disabled', 'true');
        $(this).find('.indicator-label').hide();
        $(this).find('.indicator-progress').show();
    	if($('#form-add').valid()){
    		$('#form-add').submit();
    	}else{
    		$(this).attr('disabled', false);
            $(this).find('.indicator-label').show();
            $(this).find('.indicator-progress').hide();
    	}
    });

    $(".format-number").keyup(function(e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $('.withseparator').maskMoney({
        prefix: '',
        suffix: '',
        thousands: ',',
        decimal: '.',
        precision: '',
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
            url: "/barang/getDataJenisBarang",
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