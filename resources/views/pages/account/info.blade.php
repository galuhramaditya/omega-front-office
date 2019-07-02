<div class="row" vue-data>
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-user font-green"></i>
                    <span class="caption-subject font-green bold uppercase">User Info</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn yellow btn-outline btn-circle btn-sm" data-toggle="modal" href="#self-edit">Edit</a>
                        @include("pages.account.self-edit")
                    </div>
                    <div class="btn-group">
                        <a class="btn purple btn-outline btn-circle btn-sm" data-toggle="modal" href="#change-self-password">Change Password</a>
                        @include("pages.account.change-self-password")
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-xs-5 text-right">
                        Username
                    </div>
                    <div class="col-xs-1" style="width: 1%"> : </div>
                    <div class="col-xs-6 bold">
                        @{{user.username}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5 text-right">
                        Permission
                    </div>
                    <div class="col-xs-1" style="width: 1%"> : </div>
                    <div class="col-xs-6 bold">
                        @{{user.admin ? "admin" : "user"}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>