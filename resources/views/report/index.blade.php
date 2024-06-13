@extends('layouts.template', ['title' => 'Report'])
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css"
        rel="stylesheet">

    <style>
        .red {
            background-color: #f87d7d !important;
        }
    </style>
@endpush
@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="range" class="col-sm-2 col-form-label">Range Date</label>
                                <div class="col-sm-10">
                                    <input type="text" id="range" class="form-control" readonly>
                                </div>
                            </div>
                            @if ($user->role == 'admin')
                                <div class="form-group row">
                                    <label for="user" class="col-sm-2 col-form-label">User</label>
                                    <div class="col-sm-10">
                                        <select name="user[]" id="user" class="form-control" style="width: 100%"
                                            multiple>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-warning" id="reset">Reset</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <h5 class="pl-3 pt-3 pr-3 pb-0">Total : <span id="total_revenue"></span></h5>
                    <table id="table" class="table dt-table-hover" style="width:100%;cursor: pointer;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('report.modal')
@endsection

@push('js')
    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"
        integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            var perpage = 20;

            $("#user").select2({
                theme: "bootstrap4",
                multiple: true,
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

            $('#range').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                maxSpan: {
                    days: 31
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                    'Last 31 Days': [moment().subtract(30, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment()],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                },
                showDropdowns: true,
                startDate: moment().startOf('month'),
                endDate: moment(),
                maxDate: moment(),
            });

            $('#range').change(function() {
                table.ajax.reload()
            })

            $('#user').change(function() {
                table.ajax.reload()
            })

            $('#reset').click(function() {
                $('#user').empty().trigger('change')
            })

            var table = $('#table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('report.data') }}",
                    data: function(dt) {
                        dt.from = $('#range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                        dt.to = $('#range').data('daterangepicker').endDate.format('YYYY-MM-DD');
                        dt.user = $('#user').val()
                    }
                },
                dom: "<'table-responsive'tr>" +
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
                searching: false,
                columnDefs: [],
                order: [
                    [0, 'desc']
                ],
                columns: [{
                    title: "Date",
                    data: 'transaction_date',
                }, {
                    title: "Amount",
                    data: 'total_profit',
                    render: function(data, type, row, meta) {
                        if (type == 'display') {
                            return hrg(data)
                        } else {
                            return data
                        }
                    }
                }, ],
                drawCallback: function(settings, json) {
                    feather.replace();
                    let data = this.api().ajax.json()
                    if (typeof(data) != 'undefined') {
                        total = 0;
                        data.data.forEach(element => {
                            total = total + parseInt(element.total_profit)
                        });
                        $('#total_revenue').html('Rp. ' + hrg(total))
                    }
                },
                initComplete: function(settings, json) {
                    feather.replace();
                }
            });

            $('#table tbody').on('click', 'tr td', function() {
                block();
                var data = table.row(this).data();
                let date = data.transaction_date
                let user = $('#user').val() || [];
                let queryString = `date=${date}&user[]=${user.join('&user[]=')}`;
                $.get("{{ route('report.date') }}?" + queryString).done(function(res) {
                    $('#detail_date').html(`<b>${date}</b>`);
                    detail_table.clear().draw();
                    detail_table.rows.add(res.data).draw();
                    $('#detailModal').modal('show');
                    unblock();
                }).fail(function(xhr) {
                    unblock();
                });
            });

            var detail_table = $('#detail_table').DataTable({
                rowId: 'id',
                lengthChange: false,
                searching: false,
                info: false,
                paging: false,
                columnDefs: [],
                order: [
                    [0, 'desc']
                ],
                createdRow: function(row, data, dataIndex) {
                    if (data.status != "success") {
                        $(row).addClass('red');
                    }
                },
                columns: [{
                    title: "Date",
                    data: 'date',
                }, {
                    title: "Number",
                    data: 'number',
                }, {
                    title: "Detail",
                    data: 'from_id',
                    render: function(data, type, row, meta) {
                        if (type == 'display') {
                            return `From : <b>${row.from.name}</b>, To : <b>${row.to.name}</b> <br> Amount: <b>${hrg(row.amount)}</b> Cost: <b>${hrg(row.cost)}</b>`
                        } else {
                            return data
                        }
                    }
                }, {
                    title: "Revenue",
                    data: 'revenue',
                    render: function(data, type, row, meta) {
                        if (type == 'display') {
                            return hrg(data)
                        } else {
                            return data
                        }
                    }
                }, ]
            });
        })
    </script>
@endpush
