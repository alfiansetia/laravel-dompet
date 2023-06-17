<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} | {{ $comp->name }} </title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}" />
    <link href="{{ asset('assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/loader.js') }}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('assets/css/plugins.css" rel="stylesheet" type="text/css') }}" />

    <link rel="stylesheet" href="{{ asset('plugins/font-icons/fontawesome/css/all.min.css') }}">


    <script src="{{ asset('plugins/sweetalerts/promise-polyfill.js') }}"></script>
    <link href="{{ asset('plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css') }}" />
    <link href="{{ asset('assets/css/components/custom-sweetalert.css" rel="stylesheet') }}" type="text/css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/animate/animate.css') }}">
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL STYLES -->
    @stack('css')
    <!-- END PAGE LEVEL STYLES -->

</head>

<body>
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    @include('layouts.nav')
    <!--  END NAVBAR  -->


    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @include('layouts.sidebar')
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">

            @yield('content')

            @include('layouts.footer')
        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <form action="{{ route('logout') }}" method="POST" id="form_logout">
        @csrf
    </form>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('plugins/font-icons/feather/feather.min.js') }}"></script>

    <script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>


    <script src="{{ asset('plugins/blockui/jquery.blockUI.min.js') }}"></script>

    <script src="{{ asset('plugins/blockui/custom-blockui.js') }}"></script>

    <script>
        $(document).ready(function() {
            App.init();

            $('body').tooltip({
                selector: '[data-toggle="tooltip"]'
            });
        });

        feather.replace();

        function logout_() {
            swal({
                title: 'Are you sure?',
                text: "You will be logout!",
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
                    $('#form_logout').submit();
                }
            })
        }

        function unblock() {
            $('button').prop('disabled', false);
            $.unblockUI();
        }

        function block() {
            $('button').prop('disabled', true);
            $.blockUI({
                message: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-loader spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        }
    </script>

    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    @stack('js')

    <!-- END PAGE LEVEL SCRIPTS -->
</body>


</html>
