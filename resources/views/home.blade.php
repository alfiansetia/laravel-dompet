@extends('components.template')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/apex/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/widgets/modules-widgets.css') }}">
@endpush
@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12 layout-spacing">
                <div class="widget widget-four">
                    <div class="widget-heading">
                        <h5 class="">Summary Dompet</h5>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-horizontal"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask"
                                    style="will-change: transform;">
                                    <a class="dropdown-item" href="javascript:void(0);">View Report</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Edit Report</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Mark as Done</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content">
                        <div class="order-summary" id="summary_content">
                            Loading
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <button class="btn btn-primary" id="tes">GET DATA</button>
@endsection
@push('js')
    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#tes').click(function() {

            })
            get_data();

            setInterval(() => {
                get_data()
            }, 5000);
        })

        function get_data() {
            $.get("{{ route('home.get.data') }}").done(function(res) {
                let data = res.data.data
                $('#summary_content').html('')
                for (let i = 0; i < data.length; i++) {
                    set_summary(data[i])
                }
                feather.replace();
            }).fail(function(xhr) {
                $('#summary_content').html('Failed load data!')
            })
        }

        var clas = ['profit', 'income', 'expenses'];

        function set_summary(data) {
            let warna = clas[Math.floor(Math.random() * clas.length)];
            let text = ''
            text = `
                <div class="summary-list summary-${warna}">
                    <div class="summery-info">
                        <div class="w-icon">
                            <i data-feather="shopping-bag"></i>
                        </div>
                        <div class="w-summary-details">
                            <div class="w-summary-info">
                                <h6>${data.name} <span class="summary-count">RP. ${hrg(data.saldo)} </span></h6>
                            </div>
                        </div>
                    </div>
                </div>`;
            $('#summary_content').append(text)
        }
    </script>
@endpush
