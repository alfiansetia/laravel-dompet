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
                        <label class="control-label" for="dompet"></i>Dompet :</label>
                        <select name="dompet" id="dompet" class="form-control" style="width: 100%;" required>
                            <option value="">Pilih Asal Dompet</option>
                        </select>
                        <span id="err_dompet" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="amount">Amount :</label>
                        <input type="text" name="amount" class="form-control maxlength mask-angka" id="amount"
                            placeholder="Please Enter Amount" min="1" value="0" required>
                        <span id="err_amount" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="desc">Desc :</label>
                        <textarea name="desc" id="desc" class="form-control maxlength" minlength="0" maxlength="100"></textarea>
                        <span id="err_desc" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"
                        data-toggle="tooltip" title="Close"></i>Close</button>
                <button type="reset" id="reset" class="btn btn-warning"><i class="fas fa-undo mr-1"
                        data-toggle="tooltip" title="Reset"></i>Reset</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1" data-toggle="tooltip"
                        title="Save"></i>Save</button>
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
                        <label class="control-label" for="edit_user">User :</label>
                        <input type="text" class="form-control" id="edit_user" readonly>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_date">Date :</label>
                        <input type="text" class="form-control" id="edit_date" readonly>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_dompet">Dompet :</label>
                        <input type="text" class="form-control" id="edit_dompet" readonly>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_amount">Amount :</label>
                        <input type="text" class="form-control" id="edit_amount" readonly>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="edit_desc">Desc :</label>
                        <textarea name="desc" id="edit_desc" class="form-control maxlength" minlength="0" maxlength="100"></textarea>
                        <span id="err_edit_desc" class="error invalid-feedback" style="display: hide;"></span>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"
                        data-toggle="tooltip" title="Close"></i>Close</button>
                <button type="button" id="edit_reset" class="btn btn-danger"><i class="fas fa-undo mr-1"
                        data-toggle="tooltip" title="Set Cancel"></i>Set Cancel</button>
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane mr-1"
                        data-toggle="tooltip" title="Save"></i>Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
