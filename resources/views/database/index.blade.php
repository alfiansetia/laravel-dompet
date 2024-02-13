@extends('layouts.template', ['title' => 'Database Backup'])
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
                            <tbody>
                            </tbody>
                        </table>
                    </form>
                </div>
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

    <script src="{{ asset('plugins/input-mask/jquery.inputmask.bundle.min.js') }}"></script>

    <script>
        function convertUnixTimestampToTime(timestamp) {
            var date = new Date(timestamp * 1000);
            var year = date.getFullYear();
            var month = date.getMonth() + 1;
            var day = date.getDate();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var seconds = date.getSeconds();

            var formattedTime = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

            return formattedTime;
        }


        function formatBytes(size) {
            var unit = [
                'Byte',
                'KiB',
                'MiB',
                'GiB',
                'TiB',
                'PiB',
                'EiB',
                'ZiB',
                'YiB'
            ];
            for (i = 0; size >= 1024 && i <= unit.length; i++) {
                size = size / 1024;
            }
            return parseFloat(size).toFixed(2) + ' ' + unit[i];
        }

        $('.maxlength').maxlength({
            placement: "top",
            alwaysShow: true
        });

        $('.mask-angka').inputmask({
            alias: 'numeric',
            groupSeparator: '.',
            autoGroup: true,
            digits: 0,
            rightAlign: false,
            removeMaskOnSubmit: true,
        });

        $('#modalAdd').on('shown.bs.modal', function() {
            set_dompet()
        });

        var table = $('#table').DataTable({
            processing: false,
            serverSide: false,
            rowId: 'id',
            ajax: "{{ route('database.index') }}",
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
                title: 'Name',
                data: 'name',
            }, {
                title: 'Size',
                data: 'size',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return formatBytes(data)
                    } else {
                        return data
                    }
                }
            }, {
                title: 'Modified',
                data: 'modified_at',
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return convertUnixTimestampToTime(data)
                    } else {
                        return data
                    }
                }
            }, {
                title: 'Action',
                orderable: false,
                data: 'name',
                className: "text-center",
                render: function(data, type, row, meta) {
                    if (type == 'display') {
                        return `
                        <button type="button" id="download" class="btn btn-sm btn-primary"><i class="fas fa-download"></i></button>
                        <button type="button" id="delete" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        `
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
                    create_backup();
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

        $('#table tbody').on('click', '#delete', function() {
            $('#formEdit .error.invalid-feedback').each(function(i) {
                $(this).hide();
            });
            $('#formEdit input.is-invalid').each(function(i) {
                $(this).removeClass('is-invalid');
            });
            let row = $(this).parents('tr')[0];
            file = table.row(row).data()
            delete_file(file.name)
        });

        $('#table tbody').on('click', '#download', function() {
            $('#formEdit .error.invalid-feedback').each(function(i) {
                $(this).hide();
            });
            $('#formEdit input.is-invalid').each(function(i) {
                $(this).removeClass('is-invalid');
            });
            let row = $(this).parents('tr')[0];
            file = table.row(row).data()
            download(file.name)
        });

        function download(file_name) {
            window.open("{{ route('database.download', '') }}/" + file_name, '_blank')
        }

        function delete_file(file_name) {
            swal({
                title: 'Are you sure?',
                text: "Delete backup file?",
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
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('database.destroy', '') }}/" + file_name,
                        data: {
                            _method: 'DELETE'
                        },
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
                            table.ajax.reload();
                            swal(
                                'Success!',
                                res.message,
                                'success'
                            )

                        },
                        error: function(xhr, status, error) {
                            unblock();
                            if (xhr.status == 422) {
                                er = xhr.responseJSON.errors
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
            })
        }

        function create_backup() {
            swal({
                title: 'Are you sure?',
                text: "Create new Backup?",
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
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('database.store') }}",
                        data: {},
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
                            table.ajax.reload();
                            swal(
                                'Success!',
                                res.message,
                                'success'
                            )

                        },
                        error: function(xhr, status, error) {
                            unblock();
                            if (xhr.status == 422) {
                                er = xhr.responseJSON.errors
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
            })
        }
    </script>
@endpush
