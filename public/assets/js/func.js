
function selected() {
    let id = $('input[name="id[]"]:checked').length;

    if (id <= 0) {
        Swal.fire({
            title: 'Failed!',
            text: "No Selected Data!",
            type: 'error',
        })
        return false
    }
    return true
}

function show_alert(message, type){
    Swal.fire({
        title: type == 'success' ? 'Success!' : 'Failed!',
        text: message,
        type: type,
    })
}

function handleResponseCode(xhr) {
    let code = xhr.status || 500
    if (code === 404) {
        Swal.fire({
            title: 'Failed!',
            text: "Not Found!",
            type: 'error',
        })
    } else if (code === 500) {
        Swal.fire({
            title: 'Failed!',
            text: "Server Error!",
            type: 'error',
        })
    } else if (code === 403) {
        Swal.fire({
            title: 'Failed!',
            text: "Unauthorize!",
            type: 'error',
        })
    } else if (code === 401) {
        Swal.fire({
            title: 'Failed!',
            text: "Unauthenticate, Please Login!",
            type: 'error',
        })
    } else {
        Swal.fire({
            title: 'Failed!',
            text: "Error! Code : " + code,
            type: 'error',
        })
    }
}

function handleResponse(jqXHR) {
    let message = jqXHR.responseJSON.message || 'Server Error!'
    Swal.fire({
        title: 'Failed!',
        text: message,
        type: 'error',
    })
}

function handleResponseForm(jqXHR, formID) {
    let message = jqXHR.responseJSON.message
    if (jqXHR.status != 422) {
        Swal.fire({
            title: 'Failed!',
            text: message,
            type: 'error',
        })
    } else {
        let errors = jqXHR.responseJSON.errors || {};
        let errorKeys = Object.keys(errors);
        
        for (let i = 0; i < errorKeys.length; i++) {
            let fieldName = errorKeys[i];
            let errorMessage = errors[fieldName][0];
            $('#' + formID + ' [name="' + fieldName + '"]').addClass('is-invalid');
            $('#' + formID + ' [name="' + fieldName + '"]').removeClass('is-valid');
            $('#' + formID + ' .err_' + fieldName).text(errorMessage).show();
        }
    }
}

function input_focus(input_name){
    $(`input[name="${input_name}"]`).focus();
}

function delete_batch() {
    if (selected()) {
        swal({
            title: 'Are you sure?',
            text: "Data Will be Lost!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
            confirmButtonAriaLabel: 'Thumbs up, Yes!',
            cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
            cancelButtonAriaLabel: 'Thumbs down',
            padding: '2em',
            animation: false,
            customClass: 'animated tada',
        }).then(function(result) {
            if (result.value) {
                let form = $("#formSelected");
                ajax_setup()
                $.ajax({
                    type: 'DELETE',
                    url: url_index,
                    data: $(form).serialize(),
                    beforeSend: function () {
                        block();
                    },
                    success: function (res) {
                        unblock();
                        table.ajax.reload();
                        show_alert(result.message, 'success')
                        Swal.fire(
                            'Success!',
                            res.message,
                            'success'
                        )
                    },
                    error: function (xhr, status, error) {
                        unblock();
                        handleResponse(xhr)
                    }
                });
            }
        })
    }
}

function delete_data(){
    swal({
        title: 'Are you sure?',
        text: "Data Will be Lost!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes!',
        confirmButtonAriaLabel: 'Thumbs up, Yes!',
        cancelButtonText: '<i class="fa fa-thumbs-down"></i> No',
        cancelButtonAriaLabel: 'Thumbs down',
        padding: '2em',
        animation: false,
        customClass: 'animated tada',
    }).then(function(result) {
        if (result.value) {
            ajax_setup();
            $.ajax({
                type: 'DELETE',
                url: url_id,
                beforeSend: function () {
                    block();
                },
                success: function (res) {
                    unblock();
                    table.ajax.reload();
                    show_alert(result.message, 'success')
                    $('#modalEdit').modal('hide')
                },
                error: function (xhr, status, error) {
                    unblock();
                    handleResponse(xhr)
                }
            });
        }
    })
}

function action_reset() {
    $('.image_preview').hide();
    clear_validate('form')
    $('#form select').val('').trigger('change');
}

function clear_validate(formID) {
    let form = $('#' + formID);
    form.find('.error.invalid-feedback').each(function() {
        $(this).hide().text('');
    });
    form.find('input.is-invalid, textarea.is-invalid, select.is-invalid').each(function() {
        $(this).removeClass('is-invalid');
        $(this).removeClass('is-valid');
    });
}

function reset() {
    $('#reset').click();
}

function ajax_setup() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });
}


function send_ajax(formID) {
    ajax_setup()
    let data = new FormData($('#' + formID)[0])
    $.ajax({
        url: $('#' + formID).attr('action'),
        method: 'POST',
        processData: false,
        contentType: false,
        data: data,
        beforeSend: function () {
            block();
            clear_validate(formID)
        },
        success: function (res) {
            unblock();
            table.ajax.reload();
            reset();
            Swal.fire(
                'Success!',
                res.message,
                'success'
            )
            $('#modalEdit').modal('hide');
            $('#modalAdd').modal('hide');
        },
        error: function (xhr, status, error) {
            unblock();
            handleResponseForm(xhr, formID)
        }
    })
}

function readURL(formID, inputName) {
    let obj = $(`#${formID} input[name="${inputName}"]`);
    if(obj.length < 0){
        return
    }
    if (obj[0].files && obj[0].files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#'+ formID +' .image_preview').show()
            $('#'+ formID +' .image_preview').attr('src', e.target.result)
        };
        reader.readAsDataURL(obj[0].files[0]);
    }
}

if($('#form').length > 0){
    $('#form').submit(function(event) {
        event.preventDefault();
    }).validate({
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            $(element).addClass('is-valid');
        },
        submitHandler: function(form) {
            send_ajax('form')
        }
    });
}

if($('#formEdit').length > 0){
    $('#formEdit').submit(function(event) {
        event.preventDefault();
    }).validate({
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            $(element).addClass('is-valid');
        },
        submitHandler: function(form) {
            send_ajax('formEdit')
        }
    });
}