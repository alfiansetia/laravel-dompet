@extends('layouts.template', ['title' => 'Data Dompet'])
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('plugins/table/datatables-buttons/css/buttons.bootstrap4.min.css') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css"
        rel="stylesheet">
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
                                    <th>Type</th>
                                    <th>Acc</th>
                                    <th>Number</th>
                                    <th>Saldo</th>
                                    <th>User</th>
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

    @include('dompet.modal')
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
        integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var url_index = "{{ route('api.dompet.index') }}";
        var url_id;
        var id;
        var perpage = 20;

        $("#type, #edit_type").select2({
            theme: "bootstrap4",
        });
        var perpage = 20;

        $("#user, #edit_user").select2({
            theme: "bootstrap4",
            ajax: {
                delay: 1000,
                url: "{{ route('api.user.paginate') }}",
                data: function(params) {
                    return {
                        name: params.term || '',
                        page: params.page || 1,
                        limit: perpage,
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: $.map(data.data, function(item) {
                            return {
                                text: item.name,
                                id: item.id,
                            }
                        }),
                        pagination: {
                            more: (params.page * perpage) < data.total
                        }
                    };
                },
            }
        });

        var table = $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: url_index,
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
                targets: [0],
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
                title: "Type",
                data: 'type',
            }, {
                title: "Account",
                data: 'acc_name',
                visible: false,
            }, {
                title: "Number",
                data: 'acc_number',
                visible: false,
            }, {
                title: 'Saldo',
                data: 'saldo',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data)
                    } else {
                        return data
                    }
                }
            }, {
                title: 'User',
                data: 'user_id',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        if (data == null) {
                            return ''
                        } else {
                            return row.user.name
                        }
                    } else {
                        return data
                    }
                }
            }, ],
            buttons: [{
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
                text: '<i class="fas fa-trash"></i>Del',
                className: 'btn btn-sm btn-danger',
                attr: {
                    'data-toggle': 'tooltip',
                    'title': 'Delete Selected Data'
                },
                action: function(e, dt, node, config) {
                    delete_batch()
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

        $('#edit_reset').click(function() {
            clear_validate('formEdit')
            edit(id, false)
        })

        $('#table tbody').on('click', 'tr td:not(:first-child)', function() {
            $('#formEdit')[0].reset()
            clear_validate('formEdit')
            id = table.row(this).id()
            url_id = url_index + "/" + id
            $('#formEdit').attr('action', url_id)
            edit(id, true)
        });

        $('#reset').click(function() {
            action_reset()
            $('#type').val('cash').change()
        })

        $('#modalAdd').on('shown.bs.modal', function() {
            $('#name').focus();
        })

        $('#modalEdit').on('shown.bs.modal', function() {
            $('#edit_name').focus();
        })

        function edit(id, show = false) {
            $.ajax({
                url: url_id,
                method: 'GET',
                success: function(result) {
                    unblock();
                    $('#formEdit .image_preview').attr('src', result.data.image);
                    $('#formEdit .image_preview').show();
                    $('#edit_name').val(result.data.name);
                    $('#edit_type').val(result.data.type).change();
                    $('#edit_acc_name').val(result.data.acc_name);
                    $('#edit_acc_number').val(result.data.acc_number);
                    if (result.data.user_id == null) {
                        $('#edit_user').val('').change();
                    } else {
                        let newOption = new Option(result.data.user.name, result.data.user_id, true,
                            true);
                        $('#edit_user').append(newOption).trigger('change');
                    }
                    if (show) {
                        $('#modalEdit').modal('show');
                    }

                },
                beforeSend: function() {
                    block();
                },
                error: function(xhr, status, error) {
                    unblock();
                    handleResponseCode(xhr)
                }
            });
        }
    </script>
    <script src="{{ asset('assets/js/func.js') }}"></script>
@endpush
