<div class="modal fade text-left" :id=`edit-${users.id}` tabindex="-1" role="dialog" aria-hidden="true" :modal-action=`edit-${users.id}`>
    <div class="modal-dialog">
        <form class='modal-content' :form-action=`edit-${users.id}` v-on:submit.prevent="account.handle_edit(users.id, users.username)">
            <div class="modal-header bg-font-green bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Account</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Role</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-cog"></i>
                        </span>
                        <select name="role" class="form-control">
                            <option v-for="role in _.orderBy(extra_container, ['level', 'name'], 'asc')" :value="role.id" :selected="role.id == users.role.id">@{{ `${role.name} (${role.level})` }}</option>
                        </select>
                    </div>
                    <div class="help-block font-red" help-name="role"></div>
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