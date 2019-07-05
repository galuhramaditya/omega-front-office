<div class="modal fade text-left" :id=`delete-${roles.id}` tabindex="-1" role="dialog" aria-hidden="true" :modal-action=`delete-${roles.id}`>
    <div class="modal-dialog">
        <form class='modal-content' :form-action=`delete-${roles.id}` v-on:submit.prevent="role.handle_delete(roles.id, roles.name)">
            <div class="modal-header bg-font-red bg-red">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Delete Role</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-unlock-alt"></i>
                        </span>
                        <input type="password" class="form-control" name="password" placeholder="Your Password"> </div>
                    <div class="help-block font-red" help-name="password"></div>
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