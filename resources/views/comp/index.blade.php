@extends('components.template')

@push('css')
    <link href="{{ asset('assets/css/users/account-setting.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form id="work-experience" method="POST" action="{{ route('comp.store') }}">
                        @csrf
                        <div class="info">
                            <h5 class="">Edit Company</h5>
                            <div class="row">
                                <div class="col-md-11 mx-auto">
                                    <div class="work-section">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <input type="text" name="name" id="name"
                                                                class="form-control mb-4 @error('name') is-invalid @enderror"
                                                                placeholder="Input Name" value="{{ $comp->name }}"
                                                                required autofocus>
                                                            @error('name')
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
                                                                placeholder="Input Phone" value="{{ $comp->phone }}"
                                                                required>
                                                            @error('phone')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="address">Address</label>
                                                            <textarea name="address" rows="5" id="address" class="form-control @error('address') is-invalid @enderror">{{ $comp->address }}</textarea>
                                                            @error('address')
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

            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <form id="work-experience" method="POST" action="{{ route('comp.store') }}">
                        @csrf
                        <div class="info">
                            <h5 class="">Edit Images Company</h5>
                            <div class="row">
                                <div class="col-md-11 mx-auto">
                                    <div class="work-section">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-12 mt-3">
                                                        <div class="custom-file-container" data-upload-id="myFirstImage">
                                                            <label>Logo <a href="javascript:void(0)"
                                                                    class="custom-file-container__image-clear"
                                                                    title="Clear Image">x</a></label>
                                                            <label class="custom-file-container__custom-file">
                                                                <input type="file"
                                                                    class="custom-file-container__custom-file__custom-file-input"
                                                                    accept="image/*">
                                                                <input type="hidden" name="MAX_FILE_SIZE"
                                                                    value="10485760" />
                                                                <span
                                                                    class="custom-file-container__custom-file__custom-file-control"></span>
                                                            </label>
                                                            <div class="custom-file-container__image-preview"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="custom-file-container" data-upload-id="myFirstImage2">
                                                            <label>Favicon <a href="javascript:void(0)"
                                                                    class="custom-file-container__image-clear"
                                                                    title="Clear Image">x</a></label>
                                                            <label class="custom-file-container__custom-file">
                                                                <input type="file"
                                                                    class="custom-file-container__custom-file__custom-file-input"
                                                                    accept="image/*">
                                                                <input type="hidden" name="MAX_FILE_SIZE"
                                                                    value="10485760" />
                                                                <span
                                                                    class="custom-file-container__custom-file__custom-file-control"></span>
                                                            </label>
                                                            <div class="custom-file-container__image-preview"></div>
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
    <script src="{{ asset('plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
    <script>
        var firstUpload = new FileUploadWithPreview('myFirstImage')
        var firstUpload2 = new FileUploadWithPreview('myFirstImage2')
        $('form').submit(function(e) {
            block()
        })
    </script>
@endpush
