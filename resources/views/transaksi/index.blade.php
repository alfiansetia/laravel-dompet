@extends('components.template')
@push('css')
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/forms/theme-checkbox-radio.css">
    <link href="{{ asset('plugins/table/datatables-buttons/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
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
                                    <th>Dompet</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Cost</th>
                                    <th>Revenue</th>
                                    <th class="text-center">Status</th>
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
                            <label class="control-label" for="name">Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="name"
                                placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                            <span id="err_name" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="type"></i>Type :</label>
                            <select name="type" id="type" class="form-control" style="width: 100%;" required>
                                <option value="cash">Cash</option>
                                <option value="ewallet">Ewallet</option>
                            </select>
                            <span id="err_type" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="acc_name">Account Name :</label>
                            <input type="text" name="acc_name" class="form-control maxlength" id="acc_name"
                                placeholder="Please Enter Account Name" minlength="3" maxlength="25" required>
                            <span id="err_acc_name" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="acc_number">Account Number :</label>
                            <input type="text" name="acc_number" class="form-control maxlength" id="acc_number"
                                placeholder="Please Enter Account Name" minlength="3" maxlength="25" required>
                            <span id="err_acc_number" class="error invalid-feedback" style="display: hide;"></span>
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
                            <label class="control-label" for="edit_name">Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="edit_name"
                                placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                            <span id="err_edit_name" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_type"></i>Type :</label>
                            <select name="type" id="edit_type" class="form-control" style="width: 100%;" required>
                                <option value="cash">Cash</option>
                                <option value="ewallet">Ewallet</option>
                            </select>
                            <span id="err_edit_type" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_acc_name">Account Name :</label>
                            <input type="text" name="acc_name" class="form-control maxlength" id="edit_acc_name"
                                placeholder="Please Enter Account Name" minlength="3" maxlength="25" required>
                            <span id="err_edit_acc_name" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_acc_number">Account Number :</label>
                            <input type="text" name="acc_number" class="form-control maxlength" id="edit_acc_number"
                                placeholder="Please Enter Account Name" minlength="3" maxlength="25" required>
                            <span id="err_edit_acc_number" class="error invalid-feedback" style="display: hide;"></span>
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
    <script src="plugins/table/datatable/datatables.js"></script>
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
            columns: [{
                title: "Dompet",
                data: 'dompet_id',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return (data != null ? row.dompet.name : '')
                    } else {
                        return data
                    }
                }
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
                title: "Type",
                data: 'type',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<span class="badge badge-${data == 'in' ? 'success' : 'danger'}">${data}</span>`
                    } else {
                        return data
                    }
                }
            }, {
                title: "Amount",
                data: 'amount',
            }, {
                title: 'Cost',
                data: 'cost',
                visible: false,
            }, {
                title: 'Revenue',
                data: 'revenue',
                visible: false,
            }, {
                title: 'Status',
                data: 'status',
                class: 'text-center',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<span class="badge badge-${data == 'success' ? 'success' : (data == 'pending' ? 'warning' : 'danger')}">${data}</span>`
                    } else {
                        return data
                    }
                }
            }, {
                title: 'Desc',
                data: 'desc',
                visible: false,
            }],
            buttons: [, {
                text: '<i class="fa fa-plus"></i>Add',
                className: 'btn btn-sm btn-primary bs-tooltip',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Add Data'
                },
                action: function(e, dt, node, config) {
                    $('#modalAdd').modal('show');
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

        $('#reset').click(function() {
            $('#form .error.invalid-feedback').each(function(i) {
                $(this).hide();
            });
            $('#form input.is-invalid').each(function(i) {
                $(this).removeClass('is-invalid');
            });
        })

        function edit(id, show = false) {
            let url = "{{ route('dompet.show', ':id') }}";
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
                        $('#edit_type').val(result.data.type).change();
                        $('#edit_acc_name').val(result.data.acc_name);
                        $('#edit_acc_number').val(result.data.acc_number);
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
