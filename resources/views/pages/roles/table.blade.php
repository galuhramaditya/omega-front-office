<div class="row">
    <div class="col-md-12" vue-data> 
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered" id="table" v-if="window.hasOwnProperty('role')">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-users font-dark"></i>
                    <span class="caption-subject bold uppercase font-dark">List of Roles</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn green btn-outline btn-circle btn-sm" data-toggle="modal" href="#create">New Account</a>
                        @include("pages.roles.create")
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <table style="font-siz" class="table table-striped table-bordered table-hover order-column">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Access to Pages</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody v-if="user != null">
                        <tr v-for="roles in _.orderBy(role.roles,['level', 'name'], 'asc')">
                            <td>@{{roles.name}}</td>
                            <td>@{{roles.level}}</td>
                            <td><div v-for="page in roles.pages">@{{page.name}}</div></td>
                            <td width="100">
                                <div class="action" v-show="roles.id != user.role.id">
                                    <a class="btn yellow btn-icon-only" data-toggle="modal" :href=`#edit-${roles.id}`>
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @include("pages.roles.edit")
                                    <a class="btn red btn-icon-only" data-toggle="modal" :href=`#delete-${roles.id}`>
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    @include("pages.roles.delete")
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>