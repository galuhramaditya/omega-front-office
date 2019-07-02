<div class="row" v-show="user.admin == 1">
    <div class="col-md-12" vue-data> 
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered" id="table">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-users font-dark"></i>
                    <span class="caption-subject bold uppercase font-dark">List Accounts</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn green btn-outline btn-circle btn-sm" data-toggle="modal" href="#create">New Account</a>
                        @include("pages.account.create")
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <table style="font-siz" class="table table-striped table-bordered table-hover order-column">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Permission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="users in _.orderBy(container,['admin', 'username'],['desc', 'asc'])">
                            <td>@{{users.username}}</td>
                            <td>@{{users.admin == 1 ? "admin" : "user"}}</td>
                            <td width="100">
                                <div class="action" v-show="users.id != user.id">
                                    <a class="btn yellow btn-icon-only" data-toggle="modal" :href=`#edit-${users.id}`>
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @include("pages.account.edit")
                                    <a class="btn red btn-icon-only" data-toggle="modal" :href=`#delete-${users.id}`>
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    @include("pages.account.delete")
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>