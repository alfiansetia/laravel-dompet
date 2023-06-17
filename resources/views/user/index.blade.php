@extends('components.template')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('plugins/table/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />
@endpush
@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form action="" id="formSelected">
                        <table id="table" class="table dt-table-hover" style="width:100%;cursor: pointer;">
                            <thead>
                                <tr>
                                    <th class="dt-no-sorting text-center" style="width: 30px;">Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th class="text-center">Role</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal animated fade fadeInDown" id="modalAdd" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus mr-1" data-toggle="tooltip"
                            title="Add Data"></i>Add Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form" class="form-vertical" action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label" for="name"><i class="far fa-user mr-1" data-toggle="tooltip"
                                    title="Full Name User"></i>Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="name"
                                placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                            <span id="err_name" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="email"><i class="far fa-envelope mr-1"
                                    data-toggle="tooltip" title="Email User"></i>Email :</label>
                            <input type="email" name="email" class="form-control maxlength" id="email"
                                placeholder="Please Enter Email" minlength="3" maxlength="50" required>
                            <span id="err_email" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="phone"><i class="fas fa-phone-alt mr-1"
                                    data-toggle="tooltip" title="Phone User"></i>Phone :</label>
                            <input type="text" name="phone" class="form-control maxlength" id="phone"
                                placeholder="Please Enter Phone" minlength="3" maxlength="15" required>
                            <span id="err_phone" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="password"><i class="fas fa-lock mr-1"
                                    data-toggle="tooltip" title="Password User"></i>Password :</label>
                            <input type="password" name="password" class="form-control maxlength" id="password"
                                placeholder="Please Enter Password" minlength="5" maxlength="100" required>
                            <span id="err_password" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="role"><i class="fas fa-user-tag mr-1"
                                    data-toggle="tooltip" title="Role User"></i>Role :</label>
                            <select name="role" id="role" class="form-control" style="width: 100%;" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <span id="err_role" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"
                            data-toggle="tooltip" title="Close"></i>Close</button>
                    <button type="reset" id="reset" class="btn btn-warning"><i class="fas fa-undo mr-1"
                            data-toggle="tooltip" title="Reset"></i>Reset</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1"
                            data-toggle="tooltip" title="Save"></i>Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal animated fade fadeInDown" id="modalEdit" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleEdit"><i class="fas fa-edit mr-1" data-toggle="tooltip"
                            title="Edit Data"></i>Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip"
                        title="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEdit" class="fofrm-vertical" action="" method="POST"
                        enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label class="control-label" for="edit_name"><i class="far fa-user mr-1"
                                    data-toggle="tooltip" title="Full Name User"></i>Name :</label>
                            <input type="hidden" name="id" id="edit_id">
                            <input type="text" name="name" class="form-control" id="edit_name"
                                placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                            <span id="err_edit_name" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_email"><i class="far fa-envelope mr-1"
                                    data-toggle="tooltip" title="Email User"></i>Email :</label>
                            <input type="email" name="email" class="form-control" id="edit_email"
                                placeholder="Please Enter Email" minlength="3" maxlength="50" required>
                            <span id="err_edit_email" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_phone"><i class="fas fa-phone-alt mr-1"
                                    data-toggle="tooltip" title="Phone User"></i>Phone :</label>
                            <input type="text" name="phone" class="form-control" id="edit_phone"
                                placeholder="Please Enter Phone" minlength="3" maxlength="15" required>
                            <span id="err_edit_phone" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_password"><i class="fas fa-lock mr-1"
                                    data-toggle="tooltip" title="Password User"></i>Password :</label>
                            <input type="password" name="password" class="form-control maxlength" id="edit_password"
                                placeholder="Please Enter Password" minlength="5">
                            <small id="sh-text1" class="form-text text-muted">Leave blank if you do not change
                                password!</small>
                            <span id="err_edit_password" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_role"><i class="fas fa-user-tag mr-1"
                                    data-toggle="tooltip" title="Role User"></i>Role :</label>
                            <select name="role" id="edit_role" class="form-control" style="width: 100%;" required>
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <span id="err_edit_role" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"
                            data-toggle="tooltip" title="Close"></i>Close</button>
                    <button type="button" id="edit_reset" class="btn btn-warning"><i class="fas fa-undo mr-1"
                            data-toggle="tooltip" title="Reset"></i>Reset</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1"
                            data-toggle="tooltip" title="Save"></i>Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('plugins/table/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/table/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/table/datatables-buttons/js/buttons.colVis.min.js') }}"></script>


    <script src="{{ asset('plugins/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-maxlength/custom-bs-maxlength.js') }}"></script>

    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <script>
        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            rowId: 'id',
            ajax: "{{ route('user.index') }}",
            dom: "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            oLanguage: {
                "oPaginate": {
                    "sPrevious": '<i data-feather="arrow-left"></i>',
                    "sNext": '<i data-feather="arrow-right"></i>'
                },
                "sSearch": '<i data-feather="search"></i>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            lengthMenu: [
                [10, 50, 100, 500, 1000],
                ['10 rows', '50 rows', '100 rows', '500 rows', '1000 rows']
            ],
            pageLength: 10,
            lengthChange: false,
            columnDefs: [{
                targets: 0,
                width: "30px",
                className: "dt-no-sorting",
                orderable: false,
            }, {
                targets: [0, 4],
                className: "text-center",
            }],
            columns: [{
                title: 'Id',
                "data": 'id',
                data: 'id',
                render: function(data, type, row, meta) {
                    return `<label class="new-control new-checkbox checkbox-outline-primary  m-auto">\n<input type="checkbox" name="id[]" value="${data}" class="new-control-input child-chk select-customers-info">\n<span class="new-control-indicator"></span><span style="visibility:hidden">c</span>\n</label>`
                }
            }, {
                title: "Name",
                data: 'name',
            }, {
                title: "Email",
                data: 'email',
            }, {
                title: "Phone",
                data: 'phone',
            }, {
                title: 'Role',
                data: 'role',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<span class="badge badge-${data == 'admin' ? 'success' : 'danger'}">${data}</span>`
                    } else {
                        return data
                    }
                }
            }, ],
            buttons: [, {
                text: '<i class="fa fa-plus"></i>Add',
                className: 'btn btn-sm btn-primary bs-tooltip',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Add Data'
                },
                action: function(e, dt, node, config) {
                    $('#modalAdd').modal('show');
                    $('#name').focus();
                }
            }, {
                text: '<i class="fas fa-trash"></i>Del',
                className: 'btn btn-sm btn-danger',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Delete Selected Data'
                },
                action: function(e, dt, node, config) {
                    deleteData()
                }
            }, {
                extend: "colvis",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Column Visible'
                },
                className: 'btn btn-sm btn-primary'
            }, {
                extend: "pageLength",
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Page Length'
                },
                className: 'btn btn-sm btn-info'
            }],
            headerCallback: function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML =
                    '<label class="new-control new-checkbox checkbox-outline-primary m-auto">\n<input type="checkbox" class="new-control-input chk-parent select-customers-info" id="customer-all-info">\n<span class="new-control-indicator"></span><span style="visibility:hidden">c</span>\n</label>'
            },
            drawCallback: function(settings) {
                feather.replace();
            },
            initComplete: function() {
                $('#tableData').DataTable().buttons().container().appendTo(
                    '#tableData_wrapper .col-md-6:eq(0)');
                feather.replace();
            }
        });

        multiCheck(table);

        var id;

        $('#edit_reset').click(function() {
            id = $(this).val();
            edit(id, false)
        })

        $('#table tbody').on('click', 'tr td:not(:first-child)', function() {
            $('#formEdit .error.invalid-feedback').each(function(i) {
                $(this).hide();
            });
            $('#formEdit input.is-invalid').each(function(i) {
                $(this).removeClass('is-invalid');
            });
            id = table.row(this).id()
            edit(id, true)
        });

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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                var formData1 = form;
                let url = "{{ route('user.update', ':id') }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $(formData1).serialize(),
                    beforeSend: function() {
                        block();
                        $('#formEdit .error.invalid-feedback').each(function(i) {
                            $(this).hide();
                        });
                        $('#formEdit input.is-invalid').each(function(i) {
                            $(this).removeClass('is-invalid');
                        });
                    },
                    success: function(res) {
                        unblock();
                        if (res.status == true) {
                            table.ajax.reload();
                            $('#reset').click();
                            $('#edit_password').val('');
                            swal(
                                'Success!',
                                res.message,
                                'success'
                            )
                        } else {
                            swal(
                                'Failed!',
                                res.message,
                                'error'
                            )
                        }
                    },
                    error: function(xhr, status, error) {
                        unblock();
                        er = xhr.responseJSON.errors
                        erlen = Object.keys(er).length
                        if (xhr.status == 422) {
                            for (i = 0; i < erlen; i++) {
                                obname = Object.keys(er)[i];
                                $('#' + obname).addClass('is-invalid');
                                $('#err_edit_' + obname).text(er[obname][0]);
                                $('#err_edit_' + obname).show();
                            }
                        } else {
                            swal(
                                'Failed!',
                                xhr.responseJSON.message,
                                'error'
                            )
                        }
                    }
                });
            }
        });

        $('#reset').click(function() {
            $('#form .error.invalid-feedback').each(function(i) {
                $(this).hide();
            });
            $('#form input.is-invalid').each(function(i) {
                $(this).removeClass('is-invalid');
            });
            $('#edit_password').val('');
        })

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
                let formData = form;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: "{{ route('user.store') }}",
                    data: $(formData).serialize(),
                    beforeSend: function() {
                        block();
                        $('#form .error.invalid-feedback').each(function(i) {
                            $(this).hide();
                        });
                        $('#form input.is-invalid').each(function(i) {
                            $(this).removeClass('is-invalid');
                        });
                    },
                    success: function(res) {
                        unblock();
                        if (res.status == true) {
                            table.ajax.reload();
                            $('#reset').click();
                            swal(
                                'Success!',
                                res.message,
                                'success'
                            )
                        } else {
                            swal(
                                'Failed!',
                                res.message,
                                'error'
                            )
                        }
                    },
                    error: function(xhr, status, error) {
                        unblock();
                        er = xhr.responseJSON.errors
                        if (xhr.status == 422) {
                            erlen = Object.keys(er).length
                            for (i = 0; i < erlen; i++) {
                                obname = Object.keys(er)[i];
                                $('#' + obname).addClass('is-invalid');
                                $('#err_' + obname).text(er[obname][0]);
                                $('#err_' + obname).show();
                            }
                        } else {
                            swal(
                                'Failed!',
                                xhr.responseJSON.message,
                                'error'
                            )
                        }
                    }
                });
            }
        });

        function edit(id, show = false) {
            let url = "{{ route('user.show', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(result) {
                    unblock();
                    if (result.status == true) {
                        $('#edit_reset').val(result.data.id);
                        $('#edit_id').val(result.data.id);
                        $('#edit_name').val(result.data.name);
                        $('#edit_email').val(result.data.email);
                        $('#edit_phone').val(result.data.phone);
                        $('#edit_password').val('');
                        $('#edit_role').val(result.data.role).change();
                        if (show) {
                            $('#modalEdit').modal('show');
                        }
                    } else {
                        swal(
                            'Failed!',
                            result.message,
                            'error'
                        )
                    }
                },
                beforeSend: function() {
                    block();
                },
                error: function(xhr, status, error) {
                    unblock();
                    er = xhr.responseJSON.errors
                    swal(
                        'Failed!',
                        xhr.responseJSON.message,
                        'error'
                    )
                }
            });
        }

        function deleteData() {
            if (selected()) {
                swal({
                    title: 'Delete Selected Data?',
                    text: "You won't be able to revert this!",
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
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'DELETE',
                            url: "{{ route('user.destroy') }}",
                            data: $(form).serialize(),
                            beforeSend: function() {
                                block();
                            },
                            success: function(res) {
                                unblock();
                                if (res.status == true) {
                                    table.ajax.reload();
                                    swal(
                                        'Success!',
                                        res.message,
                                        'success'
                                    )
                                } else {
                                    swal(
                                        'Failed!',
                                        res.message,
                                        'error'
                                    )
                                }
                            },
                            error: function(xhr, status, error) {
                                unblock();
                                er = xhr.responseJSON.errors
                                if (xhr.status == 500) {
                                    swal(
                                        'Failed!',
                                        'Server Error',
                                        'error'
                                    )
                                } else {
                                    swal(
                                        'Failed!',
                                        xhr.responseJSON.message,
                                        'error'
                                    )
                                }
                            }
                        });
                    }
                })
            }
        }

        function selected() {
            let id = $('input[name="id[]"]:checked').length;
            if (id <= 0) {
                swal({
                    title: 'Failed!',
                    text: "No Selected Data!",
                    type: 'error',
                })
                return false
            }
            return true
        }
    </script>
@endpush
