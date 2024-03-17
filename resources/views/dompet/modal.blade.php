<div class="modal animated fade fadeInDown" id="modalAdd" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-plus mr-1" data-toggle="tooltip"
                        title="Add Data"></i>Add Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" data-toggle="tooltip" title="Close">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form" class="form-vertical" action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label class="control-label" for="name">Name :</label>
                        <input type="text" name="name" class="form-control maxlength" id="name"
                            placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                        <span id="err_name" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="type"></i>Type :</label>
                        <select name="type" id="type" class="form-control" style="width: 100%;" required>
                            <option value="cash">Cash</option>
                            <option value="ewallet">Ewallet</option>
                        </select>
                        <span id="err_type" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="acc_name">Account Name :</label>
                        <input type="text" name="acc_name" class="form-control maxlength" id="acc_name"
                            placeholder="Please Enter Account Name" minlength="3" maxlength="25" required>
                        <span id="err_acc_name" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="acc_number">Account Number :</label>
                        <input type="text" name="acc_number" class="form-control maxlength" id="acc_number"
                            placeholder="Please Enter Account Name" minlength="3" maxlength="25" required>
                        <span id="err_acc_number" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="user"></i>User :</label>
                        <select name="user" id="user" class="form-control" style="width: 100%;" required>
                            <option value="">Select User</option>

                        </select>
                        <span id="err_user" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"
                        data-toggle="tooltip" title="Close"></i>Close</button>
                <button type="reset" id="reset" class="btn btn-warning"><i class="fas fa-undo mr-1"
                        data-toggle="tooltip" title="Reset"></i>Reset</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1"
                        data-toggle="tooltip" title="Save"></i>Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal animated fade fadeInDown" id="modalEdit" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true" data-backdrop="static">
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
                <form id="formEdit" class="fofrm-vertical" action="" method="POST"
                    enctype="multipart/form-data">
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
                    <div class="form-group">
                        <label class="control-label" for="edit_user"></i>User :</label>
                        <select name="user" id="edit_user" class="form-control" style="width: 100%;" required>
                            <option value="">Select User</option>

                        </select>
                        <span id="err_edit_user" class="error invalid-feedback" style="display: hide;"></span>
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
