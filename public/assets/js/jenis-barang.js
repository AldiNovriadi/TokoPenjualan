$(document).ready(function(){
    $('#form-add').validate({
        errorClass: "invalid-feedback",
        ignore: [],
        errorElement: 'div',
        validClass: "valid-feedback",
        rules: {
            nama: {
                required: true,
            },
        },
        messages: {
            nama: {
                required: "Silahkan mengisi Nama",
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
});