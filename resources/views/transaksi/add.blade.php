@extends('components.template')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/table/datatable/dt-global_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
    <link href="{{ asset('plugins/table/datatables-buttons/css/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
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
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Amount</th>
                                    <th>Cost</th>
                                    <th>Revenue</th>
                                    <th class="text-center">Status</th>
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

    <div class="modal animated fade fadeInDown" id="modalEdit" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleEdit"><i class="fas fa-edit mr-1" data-toggle="tooltip"
                            title="Edit Data"></i>Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-toggle="tooltip"
                        title="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEdit" class="fofrm-vertical" action="" method="POST" enctype="multipart/form-data">
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label class="control-label" for="edit_name">Name :</label>
                            <input type="text" name="name" class="form-control maxlength" id="edit_name"
                                placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                            <span id="err_edit_name" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_type"></i>Type :</label>
                            <select name="type" id="edit_type" class="form-control" style="width: 100%;" required>
                                <option value="cash">Cash</option>
                                <option value="ewallet">Ewallet</option>
                            </select>
                            <span id="err_edit_type" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_acc_name">Account Name :</label>
                            <input type="text" name="acc_name" class="form-control maxlength" id="edit_acc_name"
                                placeholder="Please Enter Account Name" minlength="3" maxlength="25" required>
                            <span id="err_edit_acc_name" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="edit_acc_number">Account Number :</label>
                            <input type="text" name="acc_number" class="form-control maxlength" id="edit_acc_number"
                                placeholder="Please Enter Account Name" minlength="3" maxlength="25" required>
                            <span id="err_edit_acc_number" class="error invalid-feedback" style="display: hide;"></span>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"
                            data-toggle="tooltip" title="Close"></i>Close</button>
                    <button type="button" id="edit_reset" class="btn btn-warning"><i class="fas fa-undo mr-1"
                            data-toggle="tooltip" title="Reset"></i>Reset</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1"
                            data-toggle="tooltip" title="Save"></i>Save</button>
                </div>
                </form>
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

    <script></script>
@endpush
