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
                                    <th>NO</th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Amount</th>
                                    <th>Cost</th>
                                    <th>Revenue</th>
                                    <th>Desc</th>
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
                            <label class="control-label" for="from"></i>From :</label>
                            <select name="from" id="from" class="form-control" style="width: 100%;" required>
                            </select>
                            <span id="err_from" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="to"></i>To :</label>
                            <select name="to" id="to" class="form-control" style="width: 100%;" required>
                            </select>
                            <span id="err_to" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="amount">Amount :</label>
                            <input type="text" name="amount" class="form-control maxlength" id="amount"
                                placeholder="Please Enter Amount" min="1" value="0" required>
                            <span id="err_amount" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="cost">Cost :</label>
                            <input type="text" name="cost" class="form-control maxlength" id="cost"
                                placeholder="Please Enter Cost" min="0" value="0">
                            <span id="err_cost" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="revenue">Revenue :</label>
                            <input type="text" name="revenue" class="form-control maxlength" id="revenue"
                                placeholder="Please Enter Revenue" min="0" value="0">
                            <span id="err_revenue" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="desc">Desc :</label>
                            <textarea name="desc" id="desc" class="form-control maxlength" minlength="0" maxlength="100"></textarea>
                            <span id="err_desc" class="error invalid-feedback" style="display: hide;"></span>
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
                            <label class="control-label" for="edit_user">User :</label>
                            <input type="text" class="form-control" id="edit_user" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_date">Date :</label>
                            <input type="text" class="form-control" id="edit_date" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_from">From :</label>
                            <input type="text" class="form-control" id="edit_from" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_to">To :</label>
                            <input type="text" class="form-control" id="edit_to" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_amount">Amount :</label>
                            <input type="text" class="form-control" id="edit_amount" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_cost">Cost :</label>
                            <input type="text" class="form-control" id="edit_cost" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_revenue">Revenue :</label>
                            <input type="text" class="form-control" id="edit_revenue" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_desc">Desc :</label>
                            <textarea name="desc" id="edit_desc" class="form-control maxlength" minlength="0" maxlength="100"></textarea>
                            <span id="err_edit_desc" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"
                            data-toggle="tooltip" title="Close"></i>Close</button>
                    <button type="button" id="edit_reset" class="btn btn-danger"><i class="fas fa-undo mr-1"
                            data-toggle="tooltip" title="Set Cancel"></i>Set Cancel</button>
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
        $('#modalAdd').on('shown.bs.modal', function() {
            set_from()
            set_to()
        });

        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            rowId: 'id',
            ajax: "{{ route('transaksi.index') }}",
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
            columnDefs: [],
            order: [
                [0, 'desc']
            ],
            columns: [{
                title: "NO",
                data: 'id',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<span data-toggle="tooltip" title="${row.status}" class="badge badge-${row.status == 'success' ? 'success' : 'danger'}">${'TRX-' + data}</span>`
                    } else {
                        return data
                    }
                }
            }, {
                title: "Date",
                data: 'date',
            }, {
                title: "User",
                data: 'user.name',
                visible: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return data != null ? row.user.name : ''
                    } else {
                        return data
                    }
                }
            }, {
                title: "From",
                data: 'from.name',
            }, {
                title: "To",
                data: 'to.name',
            }, {
                title: "Amount",
                data: 'amount',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data)
                    } else {
                        return data
                    }
                }
            }, {
                title: 'Cost',
                data: 'cost',
                visible: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data)
                    } else {
                        return data
                    }
                }
            }, {
                title: 'Revenue',
                data: 'revenue',
                visible: false,
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data)
                    } else {
                        return data
                    }
                }
            }, {
                title: 'Desc',
                data: 'desc',
                visible: false,
            }],
            buttons: [{
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

        $('#table tbody').on('click', 'tr td', function() {
            id = table.row(this).id()
            edit(id, true)
        });

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
                    url: "{{ route('transaksi.store') }}",
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
                            $('#modalAdd').modal('hide');
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
                let url = "{{ route('transaksi.update', ':id') }}";
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

        $('#edit_reset').click(function() {
            let id = $(this).val();
            swal({
                title: 'Cancel Transaksi?',
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
                    let url = "{{ route('transaksi.destroy', ':id') }}";
                    url = url.replace(':id', id);
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        success: function(result) {
                            unblock();
                            if (result.status == true) {
                                table.ajax.reload();
                                $('#modalEdit').modal('hide');
                                swal(
                                    'Success!',
                                    result.message,
                                    'success'
                                )
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
            })
        })

        function edit(id, show = false) {
            let url = "{{ route('transaksi.show', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method: 'GET',
                success: function(result) {
                    unblock();
                    if (result.status == true) {
                        $('#edit_reset').val(result.data.id);
                        $('#edit_id').val(result.data.id);
                        $('#edit_date').val(result.data.date);
                        $('#edit_user').val(result.data.user.name)
                        $('#edit_from').val(result.data.from.name)
                        $('#edit_to').val(result.data.to.name)
                        $('#edit_amount').val(hrg(result.data.amount));
                        $('#edit_cost').val(hrg(result.data.cost));
                        $('#edit_revenue').val(hrg(result.data.revenue));
                        $('#edit_desc').val(result.data.desc);
                        if (result.data.status == 'success') {
                            $('#edit_reset').prop('disabled', false)
                        } else {
                            $('#edit_reset').prop('disabled', true)
                        }
                        $('.title-edit').remove()
                        $('#titleEdit').append(
                            `<span class="badge title-edit ml-2 badge-${result.data.status == 'success' ? 'success' : 'danger'}">TRX-${result.data.id}`
                        )

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

        function set_from() {
            $('#from').empty()
            $.get("{{ route('dompet.index') }}").done(function(res) {
                for (i = 0; i < res.data.length; i++) {
                    let newOption = new Option(res.data[i].name, res.data[i].id);
                    if (res.data[i].saldo < 1) {
                        $(newOption).prop('disabled', true);
                    }
                    $('#from').append(newOption);
                }
            })
        }

        function set_to() {
            $('#to').empty()
            $.get("{{ route('dompet.index') }}").done(function(res) {
                for (i = 0; i < res.data.length; i++) {
                    let newOption = new Option(res.data[i].name, res.data[i].id);
                    $('#to').append(newOption);
                }
            })
        }
    </script>
@endpush
