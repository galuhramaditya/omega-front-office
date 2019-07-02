<div class="modal fade text-left" :id=`edit-${users.id}` tabindex="-1" role="dialog" aria-hidden="true" :modal-action=`edit-${users.id}`>
    <div class="modal-dialog">
        <form class='modal-content' :form-action=`edit-${users.id}` v-on:submit.prevent="account.handle_edit(users.id, users.username)">
            <div class="modal-header bg-font-green bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Account</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Permission</label>
                    <div class="mt-radio-inline">
                        <label class="mt-radio">
                            <input type="radio" name="permission" value="user" :checked="users.admin == 0"> User
                            <span></span>
                        </label>
                        <label class="mt-radio">
                            <input type="radio" name="permission" value="admin" :checked="users.admin == 1"> Admin
                            <span></span>
                        </label>
                        <div class="help-block font-red" help-name="permission"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                <button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->