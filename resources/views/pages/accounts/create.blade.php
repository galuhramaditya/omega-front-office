<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-hidden="true" modal-action="create">
    <div class="modal-dialog">
        <form class='modal-content' form-action="create" v-on:submit.prevent="account.handle_create()">
            <div class="modal-header bg-font-green bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Create New Account</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input type="text" class="form-control" name="username" placeholder="Username"> </div>
                    <div class="help-block font-red" help-name="username"></div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-unlock-alt"></i>
                        </span>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="help-block font-red" help-name="password"></div>
                </div>
                <div class="form-group">
                    <label>Password Confirmation</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-unlock-alt"></i>
                        </span>
                        <input type="password" class="form-control" name="password_confirmation" placeholder="Password Confirmation">
                    </div>
                    <div class="help-block font-red" help-name="password_confirmation"></div>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-cog"></i>
                        </span>
                        <select name="role" class="form-control">
                            <option disabled selected hidden>select role</option>
                            <option v-for="role in _.orderBy(account.roles, ['level', 'name'], 'asc')" :value="role.id">@{{ `${role.name} (${role.level})` }}</option>
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