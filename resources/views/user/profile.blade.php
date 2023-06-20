@extends('components.template')

@push('css')
    <link href="{{ asset('assets/css/users/account-setting.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/elements/avatar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form id="work-experience" method="POST" action="{{ route('user.profile.update') }}">
                        @csrf
                        <div class="info">
                            <h5 class="">Edit Profile</h5>
                            <div class="row">
                                <div class="col-md-11 mx-auto">
                                    <div class="work-section">
                                        <div class="row mt-2">
                                            @if (auth()->user()->status == 'nonactive')
                                                <div class="col-md-12">
                                                    <div class="alert alert-light-danger border-0 mb-4" role="alert">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <i data-feather="x" class="close"></i>
                                                        </button>
                                                        <strong>Error!</strong> Your Account is Nonactive!
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Name</label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control mb-4 @error('name') is-invalid @enderror"
                                                        placeholder="Input Name" value="{{ auth()->user()->name }}" required
                                                        autofocus>
                                                    @error('name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email" name="email" id="email"
                                                                class="form-control mb-4 @error('email') is-invalid @enderror"
                                                                placeholder="Input Email"
                                                                value="{{ auth()->user()->email }}" required>
                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="phone">Phone</label>
                                                            <input type="tel" name="phone" id="phone"
                                                                class="form-control mb-4 @error('phone') is-invalid @enderror"
                                                                placeholder="Input Phone"
                                                                value="{{ auth()->user()->phone }}" required>
                                                            @error('phone')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="avatar">Avatar:</label>
                                                            <div class="avatar-options">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="avatar" id="avatar1" value="boy1.png"
                                                                        {{ auth()->user()->getRawOriginal('avatar') == 'boy1.png'? 'checked': '' }}>
                                                                    <label class="form-check-label" for="avatar1">
                                                                        <img src="{{ asset('images/avatar/boy1.png') }}"
                                                                            class="avatar-image avatar avatar-xl">
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="avatar" id="avatar2" value="boy2.png"
                                                                        {{ auth()->user()->getRawOriginal('avatar') == 'boy2.png'? 'checked': '' }}>
                                                                    <label class="form-check-label" for="avatar2">
                                                                        <img src="{{ asset('images/avatar/boy2.png') }}"
                                                                            class="avatar-image avatar avatar-xl">
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="avatar" id="avatar3" value="girl1.png"
                                                                        {{ auth()->user()->getRawOriginal('avatar') == 'girl1.png'? 'checked': '' }}>
                                                                    <label class="form-check-label" for="avatar3">
                                                                        <img src="{{ asset('images/avatar/girl1.png') }}"
                                                                            class="avatar-image avatar avatar-xl">
                                                                    </label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="avatar" id="avatar4" value="girl2.png"
                                                                        {{ auth()->user()->getRawOriginal('avatar') == 'girl2.png'? 'checked': '' }}>
                                                                    <label class="form-check-label" for="avatar4">
                                                                        <img src="{{ asset('images/avatar/girl2.png') }}"
                                                                            class="avatar-image avatar avatar-xl">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 d-flex justify-content-end mt-3">
                                                        <button type="reset" class="btn btn-warning">Reset</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form id="change-password" method="POST" action="{{ route('user.password.update') }}">
                        @csrf
                        <div class="info">
                            <h5 class="">Change Password</h5>
                            <div class="row">
                                <div class="col-md-11 mx-auto">
                                    <div class="work-section">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="password">New Password</label>
                                                            <input type="password" name="password" id="password"
                                                                class="form-control mb-4 @error('password') is-invalid @enderror"
                                                                placeholder="Input Password" minlength="5" required>
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="confirm_password">Confirm New Password</label>
                                                            <input type="password" name="confirm_password"
                                                                id="confirm_password" placeholder="Input Confirm Password"
                                                                class="form-control mb-4 @error('confirm_password') is-invalid @enderror"
                                                                minlength="5" required>
                                                            @error('confirm_password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 d-flex justify-content-end mt-3">
                                                        <button type="reset" class="btn btn-warning">Reset</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('form').submit(function(e) {
            block()
        })
    </script>
@endpush
