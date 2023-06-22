@extends('components.template')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/apex/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/widgets/modules-widgets.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/apex/apexcharts.css') }}">
@endpush
@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">

            <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-chart-one">
                    <div class="widget-heading">
                        <h5 class="">Revenue Bulan Ini</h5>
                        <div class="task-action">
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="pendingTask"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="more-horizontal"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask"
                                    style="will-change: transform;">
                                    <a class="dropdown-item" href="javascript:void(0);">Weekly</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Monthly</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Yearly</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="widget-content">
                        <div id="revenueMonthly"></div>
                    </div>
                </div>
            </div>

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

            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
                <div class="widget widget-card-four">
                    <div class="widget-content">
                        <div class="w-header">
                            <div class="w-info">
                                <h6 class="value">Total Profit</h6>
                            </div>
                            <div class="task-action">
                                <div class="dropdown">
                                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i data-feather="more-horizontal"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="pendingTask"
                                        style="will-change: transform;">
                                        <a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Last Week</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="w-content">
                            <div class="w-info">
                                <p class="value" id="value_profit">Loading ..</p>
                            </div>
                        </div>

                        <div class="w-progress-stats">
                            <div class="progress" id="profit_progress">
                                <div class="progress-bar bg-gradient-secondary" role="progressbar" style="width: 57%"
                                    aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="">
                                <div class="w-icon">
                                    <p id="profit_percent">Loading..</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('plugins/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#refresh').click(function() {
                block()
                get_chart()
                get_data()
                unblock()
            })

            get_chart();
            get_data();

            setInterval(() => {
                get_data()
            }, 10000);

            setInterval(() => {
                get_data()
            }, 11000);

        })

        var options1 = {
            chart: {
                fontFamily: 'Nunito, sans-serif',
                height: 365,
                type: 'area',
                zoom: {
                    enabled: false
                },
                dropShadow: {
                    enabled: true,
                    opacity: 0.2,
                    blur: 10,
                    left: -7,
                    top: 22
                },
                toolbar: {
                    show: false
                },
                events: {
                    mounted: function(ctx, config) {
                        const highest1 = ctx.getHighestValueInSeries(0);
                        ctx.addPointAnnotation({
                            x: new Date(ctx.w.globals.seriesX[0][ctx.w.globals.series[0]
                                .indexOf(highest1)
                            ]).getTime(),
                            y: highest1,
                            label: {
                                style: {
                                    cssClass: 'd-none'
                                }
                            },
                            customSVG: {
                                SVG: '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#1b55e2" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="feather feather-circle"><circle cx="12" cy="12" r="10"></circle></svg>',
                                cssClass: undefined,
                                offsetX: -8,
                                offsetY: 5
                            }
                        })

                    },
                }
            },
            colors: ['#1b55e2'],
            dataLabels: {
                enabled: false
            },
            markers: {
                discrete: [{
                    seriesIndex: 0,
                    dataPointIndex: 7,
                    fillColor: '#000',
                    strokeColor: '#000',
                    size: 5
                }, {
                    seriesIndex: 2,
                    dataPointIndex: 11,
                    fillColor: '#000',
                    strokeColor: '#000',
                    size: 4
                }]
            },
            stroke: {
                show: true,
                curve: 'smooth',
                width: 2,
                lineCap: 'square'
            },
            series: [{
                name: 'Expenses',
                data: [0]
            }],
            labels: [''],
            xaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                crosshairs: {
                    show: true
                },
                labels: {
                    offsetX: 0,
                    offsetY: 5,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Nunito, sans-serif',
                        cssClass: 'apexcharts-xaxis-title',
                    },
                }
            },
            yaxis: {
                labels: {
                    formatter: function(value, index) {
                        return (value / 1000) + 'K'
                    },
                    offsetX: -22,
                    offsetY: 0,
                    style: {
                        fontSize: '12px',
                        fontFamily: 'Nunito, sans-serif',
                        cssClass: 'apexcharts-yaxis-title',
                    },
                }
            },
            grid: {
                borderColor: '#e0e6ed',
                strokeDashArray: 5,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false,
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: -10
                },
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                offsetY: -50,
                fontSize: '16px',
                fontFamily: 'Nunito, sans-serif',
                markers: {
                    width: 10,
                    height: 10,
                    strokeWidth: 0,
                    strokeColor: '#fff',
                    fillColors: undefined,
                    radius: 12,
                    onClick: undefined,
                    offsetX: 0,
                    offsetY: 0
                },
                itemMargin: {
                    horizontal: 0,
                    vertical: 20
                }
            },
            tooltip: {
                theme: 'dark',
                marker: {
                    show: true,
                },
                x: {
                    show: false,
                }
            },
            fill: {
                type: "gradient",
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: !1,
                    opacityFrom: .28,
                    opacityTo: .05,
                    stops: [45, 100]
                }
            },
            responsive: [{
                breakpoint: 575,
                options: {
                    legend: {
                        offsetY: -30,
                    },
                },
            }]
        }

        var chart = new ApexCharts(
            document.querySelector("#revenueMonthly"),
            options1
        );
        chart.render();

        function get_chart() {
            $.get("{{ route('home.get.chart') }}").done(function(res) {
                updateChartData(res.data, res.labels)
            }).fail(function(xhr) {
                console.log(xhr);
            })
        }

        function get_data() {
            $.get("{{ route('home.get.data') }}").done(function(res) {
                let data = res.data.dompet.data
                let profit = res.data.profit
                let modal = res.data.modal

                $('#summary_content').html('')
                for (let i = 0; i < data.length; i++) {
                    set_summary(data[i])
                }
                $('#value_profit').text('Rp. ' + hrg(profit))

                let progressValue = parseInt(profit) * 100 / parseInt(modal);
                let prog = progressValue.toFixed(2)

                $('#profit_progress .progress-bar').css('width', prog + '%');
                $('#profit_progress .progress-bar').attr('aria-valuenow', prog);
                $('#profit_percent').text(prog + '%');

                feather.replace();
            }).fail(function(xhr) {
                $('#summary_content').html('Failed load data!')
                $('#value_profit').html('Failed load data!')
            })
        }

        function updateChartData(newData, newLabels) {
            chart.updateOptions({
                xaxis: {
                    categories: []
                }
            });
            chart.updateSeries([]);
            chart.updateOptions({
                xaxis: {
                    categories: newLabels
                }
            });
            chart.updateSeries([{
                name: 'Revenue',
                data: newData
            }]);
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
