<form id="form" class="form-vertical" action="{{ route('api.user.store') }}" method="POST"
    enctype="multipart/form-data">
    @method('POST')
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
                    <div class="form-group">
                        <label class="control-label" for="name"><i class="far fa-user mr-1" data-toggle="tooltip"
                                title="Full Name User"></i>Name :</label>
                        <input type="text" name="name" class="form-control maxlength" id="name"
                            placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                        <span class="error invalid-feedback err_name" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="email"><i class="far fa-envelope mr-1"
                                data-toggle="tooltip" title="Email User"></i>Email :</label>
                        <input type="email" name="email" class="form-control maxlength" id="email"
                            placeholder="Please Enter Email" minlength="3" maxlength="50" required>
                        <span class="error invalid-feedback err_email" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="phone"><i class="fas fa-phone-alt mr-1"
                                data-toggle="tooltip" title="Phone User"></i>Phone :</label>
                        <input type="text" name="phone" class="form-control maxlength" id="phone"
                            placeholder="Please Enter Phone" minlength="3" maxlength="15" required>
                        <span class="error invalid-feedback err_phone" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password"><i class="fas fa-lock mr-1" data-toggle="tooltip"
                                title="Password User"></i>Password :</label>
                        <input type="password" name="password" class="form-control maxlength" id="password"
                            placeholder="Please Enter Password" minlength="5" maxlength="100" required>
                        <span class="error invalid-feedback err_password" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="role"><i class="fas fa-user-tag mr-1"
                                data-toggle="tooltip" title="Role User"></i>Role :</label>
                        <select name="role" id="role" class="form-control select2" style="width: 100%;"
                            required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <span class="error invalid-feedback err_role" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="status"><i class="fas fa-user-tag mr-1"
                                data-toggle="tooltip" title="Status User"></i>Status :</label>
                        <select name="status" id="status" class="form-control select2" style="width: 100%;"
                            required>
                            <option value="active">Active</option>
                            <option value="nonactive">Nonactive</option>
                        </select>
                        <span class="error invalid-feedback err_status" style="display: hide;"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                    <button type="reset" id="reset" class="btn btn-warning"><i class="fas fa-undo mr-1"
                            data-toggle="tooltip" title="Reset"></i>Reset</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1"
                            data-toggle="tooltip" title="Save"></i>Save</button>
                </div>
            </div>
        </div>
    </div>
</form>


<form id="formEdit" class="fofrm-vertical" action="" method="POST" enctype="multipart/form-data">
    @method('PUT')
    <div class="modal animated fade fadeInDown" id="modalEdit" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleEdit"><i class="fas fa-edit mr-1" data-toggle="tooltip"
                            title="Edit Data"></i>Edit Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                        data-toggle="tooltip" title="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="edit_name"><i class="far fa-user mr-1"
                                data-toggle="tooltip" title="Full Name User"></i>Name :</label>
                        <input type="hidden" name="id" id="edit_id">
                        <input type="text" name="name" class="form-control" id="edit_name"
                            placeholder="Please Enter Name" minlength="3" maxlength="25" required>
                        <span class="error invalid-feedback err_name" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_email"><i class="far fa-envelope mr-1"
                                data-toggle="tooltip" title="Email User"></i>Email :</label>
                        <input type="email" name="email" class="form-control" id="edit_email"
                            placeholder="Please Enter Email" minlength="3" maxlength="50" required>
                        <span class="error invalid-feedback err_email" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_phone"><i class="fas fa-phone-alt mr-1"
                                data-toggle="tooltip" title="Phone User"></i>Phone :</label>
                        <input type="text" name="phone" class="form-control" id="edit_phone"
                            placeholder="Please Enter Phone" minlength="3" maxlength="15" required>
                        <span class="error invalid-feedback err_phone" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_password"><i class="fas fa-lock mr-1"
                                data-toggle="tooltip" title="Password User"></i>Password :</label>
                        <input type="password" name="password" class="form-control maxlength" id="edit_password"
                            placeholder="Please Enter Password" minlength="5">
                        <small id="sh-text1" class="form-text text-muted">Leave blank if you do not change
                            password!</small>
                        <span class="error invalid-feedback err_password" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_role"><i class="fas fa-user-tag mr-1"
                                data-toggle="tooltip" title="Role User"></i>Role :</label>
                        <select name="role" id="edit_role" class="form-control select2" style="width: 100%;"
                            required>
                            <option value="">Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                        <span class="error invalid-feedback err_role" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_status"><i class="fas fa-user-tag mr-1"
                                data-toggle="tooltip" title="Status User"></i>Status :</label>
                        <select name="status" id="edit_status" class="form-control select2" style="width: 100%;"
                            required>
                            <option value="">Select Status</option>
                            <option value="active">Active</option>
                            <option value="nonactive">Nonactive</option>
                        </select>
                        <span class="error invalid-feedback err_status" style="display: hide;"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-times mr-1" data-toggle="tooltip" title="Close"></i>Close</button>
                    <button type="button" id="edit_reset" class="btn btn-warning"><i class="fas fa-undo mr-1"
                            data-toggle="tooltip" title="Reset"></i>Reset</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1"
                            data-toggle="tooltip" title="Save"></i>Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
