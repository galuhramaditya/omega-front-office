<div class="modal fade" id="change-self-password" tabindex="-1" role="dialog" aria-hidden="true" modal-action="change-self-password">
    <div class="modal-dialog">
        <form class='modal-content' form-action="change-self-password" v-on:submit.prevent="account.handle_change_self_password()">
            <div class="modal-header bg-font-purple bg-purple">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Change Password</h4>
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
                <div class="form-group">
                    <label>New Password</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-unlock-alt"></i>
                        </span>
                        <input type="password" class="form-control" name="new_password" placeholder="New Password"> </div>
                    <div class="help-block font-red" help-name="new_password"></div>
                </div>
                <div class="form-group">
                    <label>New Password Confirmation</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-unlock-alt"></i>
                        </span>
                        <input type="password" class="form-control" name="new_password_confirmation" placeholder="New Password Confirmation"> </div>
                    <div class="help-block font-red" help-name="new_password_confirmation"></div>
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