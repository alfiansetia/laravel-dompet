@extends('layouts.template', ['title' => 'Data Transaksi'])
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
    @include('transaksi.modal')
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

    <script src="{{ asset('plugins/input-mask/jquery.inputmask.bundle.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
        integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('assets/js/func.js') }}"></script>
    <script>
        var url_index = "{{ route('api.transaksi.index') }}";
        var url_id;
        var id;
        var perpage = 20;

        $(document).ready(function() {
            $('.maxlength').maxlength({
                placement: "top",
                alwaysShow: true
            });

            $('#sell').on('input', function() {
                set_revenue()
            })

            $('#amount').on('input', function() {
                set_revenue()
            })
        })

        $('.mask-angka').inputmask({
            alias: 'numeric',
            groupSeparator: '.',
            autoGroup: true,
            digits: 0,
            rightAlign: false,
            removeMaskOnSubmit: true,
        });

        function set_revenue() {
            let sell = $('#sell').inputmask('unmaskedvalue') ?? 0
            let amount = $('#amount').inputmask('unmaskedvalue') ?? 0
            let selisih = sell - amount
            if (selisih < 0) {
                $('#sell').addClass('is-invalid');
                $('#err_sell').text('Harga jual tidak boleh lebih rendah dari harga beli');
                $('#err_sell').show();
                $('#revenue').val(0)
            } else {
                $('#sell').removeClass('is-invalid');
                $('#err_sell').hide();
                $('#revenue').val(selisih)
            }
        }

        $("#from, #to").select2({
            theme: "bootstrap4",
            ajax: {
                delay: 1000,
                url: "{{ route('api.dompet.paginate') }}",
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
            columnDefs: [],
            order: [
                [0, 'desc']
            ],
            columns: [{
                data: 'number',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `<span data-toggle="tooltip" title="${row.status}" class="badge badge-${row.status == 'success' ? 'success' : 'danger'}">${data}</span>`
                    } else {
                        return data
                    }
                }
            }, {
                data: 'date',
            }, {
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
                data: 'from.name',
            }, {
                data: 'to.name',
            }, {
                data: 'amount',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return hrg(data)
                    } else {
                        return data
                    }
                }
            }, {
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

        $('#table tbody').on('click', 'tr td', function() {
            $('#formEdit')[0].reset()
            clear_validate('formEdit')
            id = table.row(this).id()
            url_id = url_index + "/" + id
            $('#formEdit').attr('action', url_id)
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
                send_ajax('form')
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
                send_ajax('formEdit')
            }
        });

        $('#edit_reset').click(function() {
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
                    ajax_setup()
                    $.ajax({
                        url: url_id,
                        method: 'DELETE',
                        success: function(result) {
                            unblock();
                            table.ajax.reload();
                            $('#modalEdit').modal('hide');
                            show_alert(result.message, 'success')
                        },
                        beforeSend: function() {
                            block();
                        },
                        error: function(xhr, status, error) {
                            unblock();
                            handleResponseCode(xhr.responseJSON.message, 'error')
                        }
                    });
                }
            })
        })

        $('#reset').click(function() {
            $('#form .error.invalid-feedback').each(function(i) {
                $(this).hide();
            });
            $('#form input.is-invalid').each(function(i) {
                $(this).removeClass('is-invalid');
            });
            $("#from, #to").val('').change()
        })

        function edit(id, show = false) {
            $.ajax({
                url: url_id,
                method: 'GET',
                success: function(result) {
                    unblock();
                    $('#edit_reset').val(result.data.id);
                    $('#edit_id').val(result.data.id);
                    $('#formEdit .image_preview').attr('src', result.data.image);
                    $('#formEdit .image_preview').show();
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
                        `<span class="badge title-edit ml-2 badge-${result.data.status == 'success' ? 'success' : 'danger'}">${result.data.number}`
                    )
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
@endpush
