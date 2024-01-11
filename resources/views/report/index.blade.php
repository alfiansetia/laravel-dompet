@extends('layouts.template', ['title' => 'Report'])
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Range Date</label>
                                <div class="col-sm-10">
                                    <input type="text" id="range" class="form-control" readonly>
                                </div>
                            </div>
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

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">List Transaction on <span id="detail_date"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="detail_table" class="table dt-table-hover" style="width:100%;cursor: pointer;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Number</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {

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

            var table = $('#table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: "{{ route('report.data') }}",
                    data: function(dt) {
                        dt.from = $('#range').data('daterangepicker').startDate.format('YYYY-MM-DD');
                        dt.to = $('#range').data('daterangepicker').endDate.format('YYYY-MM-DD');
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
                var data = table.row(this).data();
                let date = data.transaction_date
                $.get("{{ route('report.date') }}?date=" + date).done(function(res) {
                    $('#detail_date').html(date)
                    detail_table.clear().draw()
                    detail_table.rows.add(res.data).draw()
                    $('#detailModal').modal('show')
                })
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
                columns: [{
                    title: "Date",
                    data: 'date',
                }, {
                    title: "Number",
                    data: 'number',
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
