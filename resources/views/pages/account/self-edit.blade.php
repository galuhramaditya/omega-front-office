<div class="modal fade" id="self-edit" tabindex="-1" role="dialog" aria-hidden="true" modal-action="self-edit">
    <div class="modal-dialog">
        <form class='modal-content' form-action="self-edit" v-on:submit.prevent="account.handle_self_edit()">
            <div class="modal-header bg-font-yellow bg-yellow">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Data</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-user"></i>
                        </span>
                        <input type="text" class="form-control" name="username" placeholder="Username" :value="user.username"> </div>
                    <div class="help-block font-red" help-name="username"></div>
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