<div class="modal fade text-left" :id=`edit-${roles.id}` tabindex="-1" role="dialog" aria-hidden="true" :modal-action=`edit-${roles.id}`>
    <div class="modal-dialog">
        <form class='modal-content' :form-action=`edit-${roles.id}` v-on:submit.prevent="role.handle_edit(roles.id, roles.name)">
            <div class="modal-header bg-font-green bg-green">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Edit Role</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-cog"></i>
                        </span>
                        <input type="text" class="form-control" name="name" placeholder="Role Name" :value="roles.name">
                    </div>
                    <div class="help-block font-red" help-name="name"></div>
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <div class="input-group" v-if="user != null">
                        <span class="input-group-addon">
                            <i class="fa fa-sort-numeric-asc"></i>
                        </span>
                        <input type="number" class="form-control" :min="user.role.level" name="level" placeholder="Level" :value="roles.level">
                    </div>
                    <div class="help-block font-red" help-name="level"></div>
                </div>
                <div class="form-group">
                    <label>Access to Pages</label>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="fa fa-file"></i>
                        </span>
                        <select name="pages" multiple class="form-control selectpicker" data-live-search="true">
                            <option v-for="page in role.pages" :value="page.id" :selected="roles.pages.hasOwnProperty(page.id)">@{{page.name}}</option>
                        </select>
                    </div>
                    <div class="help-block font-red" help-name="pages"></div>
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