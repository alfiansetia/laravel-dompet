<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{ $title }} | {{ $comp->name }} </title>
    <link rel="icon" type="image/x-icon" href="{{ $comp->fav }}" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/authentication/form-2.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/switches.css') }}">
</head>

<body class="form">

    <div class="form-container outer">
        <div class="form-form">
            <div class="form-form-wrap">
                <div class="form-container">
                    <div class="form-content">
                        <div class="mb-3">
                            <img src="{{ $comp->logo }}" alt="" width="120">
                        </div>
                        <h1 class="">Sign In</h1>
                        <p class="">Log in to your account to continue.</p>

                        <form class="text-left" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form">
                                <div id="email-field" class="field-wrapper input">
                                    <label for="email">EMAIL</label>
                                    <i data-feather="user"></i>
                                    <input id="email" name="email" type="email"
                                        class="form-control  @error('email') is-invalid @enderror"
                                        placeholder="user@gmail.com" value="{{ old('email') }}" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <div class="d-flex justify-content-between">
                                        <label for="password">PASSWORD</label>
                                        <a href="javascript:void(0);" class="forgot-pass-link" onclick="forgot()">Forgot
                                            Password?</a>
                                    </div>
                                    <i data-feather="lock"></i>
                                    <input id="password" name="password" type="password" class="form-control"
                                        placeholder="Password" required autocomplete="current-password">
                                    <i data-feather="eye" id="toggle-password"></i>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="field-wrapper terms_condition">
                                    <div class="n-chk">
                                        <label class="new-control new-checkbox checkbox-primary">
                                            <input type="checkbox" class="new-control-input" name="remember"
                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <span class="new-control-indicator"></span><span>Remember Me</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper">
                                        <button type="submit" class="btn btn-primary" value="">Log In</button>
                                    </div>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/font-icons/feather/feather.min.js') }}"></script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets/js/authentication/form-2.js') }}"></script>

    <script>
        $(document).ready(function() {
            feather.replace();

            $('form').submit(function(event) {
                $('button[type="submit"]').prop('disabled', true);
            })

            $('#toggle-password').click(function() {
                pw()
            })

        })

        function forgot() {
            alert("Hubungi Admin!")
        }

        function pw() {
            var togglePassword = document.getElementById("toggle-password");
            var formContent = document.getElementsByClassName('form-content')[0];
            var getFormContentHeight = formContent.clientHeight;
            var formImage = document.getElementsByClassName('form-image')[0];
            if (formImage) {
                var setFormImageHeight = formImage.style.height = getFormContentHeight + 'px';
            }
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }

        }

        function con_pw() {
            var y = document.getElementById("password_confirm");
            if (y.type === "password") {
                y.type = "text";
            } else {
                y.type = "password";
            }
        }
    </script>

</body>

</html>
