<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered" vue-data>
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user font-green"></i>
                    <span class="caption-subject font-green bold uppercase">User Info</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn yellow btn-outline btn-circle btn-sm" data-toggle="modal" href="#self-edit">Edit</a>
                        @include("pages.profile.self-edit")
                    </div>
                    <div class="btn-group">
                        <a class="btn purple btn-outline btn-circle btn-sm" data-toggle="modal" href="#change-self-password">Change Password</a>
                        @include("pages.profile.change-self-password")
                    </div>
                </div>
            </div>
            <div class="portlet-body table-responsive table-scrollable" style="border: 0px" v-if="user != null">
                <table class="table">
                    <tr>
                        <td class="text-right" style="width: 50%">Company Name</td>
                        <td class="bold" style="width: 50%">@{{user.conm}}</td>
                    </tr>
                    <tr>
                        <td class="text-right">Username</td>
                        <td class="bold">@{{user.username}}</td>
                    </tr>
                    <tr>
                        <td class="text-right">Role</td>
                        <td class="bold">@{{user.role.name}}</td>
                    </tr>
                    <tr>
                        <td class="text-right">Level</td>
                        <td class="bold">@{{user.role.level}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>