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
            <div class="portlet-body" v-if="user != null">
                <div class="row">
                    <div class="col-xs-5 text-right">
                        Company Name
                    </div>
                    <div class="col-xs-1" style="width: 1%"> : </div>
                    <div class="col-xs-6 bold">
                        @{{user.conm}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5 text-right">
                        Username
                    </div>
                    <div class="col-xs-1" style="width: 1%"> : </div>
                    <div class="col-xs-6 bold">
                        @{{user.username}}
                    </div>
                </div>
                <div class="row" v-if="user.role != null">
                    <div class="col-xs-5 text-right">
                        Role
                    </div>
                    <div class="col-xs-1" style="width: 1%"> : </div>
                    <div class="col-xs-6 bold">
                        @{{user.role.name}}
                    </div>
                </div>
                <div class="row" v-if="user.role != null">
                    <div class="col-xs-5 text-right">
                        Level
                    </div>
                    <div class="col-xs-1" style="width: 1%"> : </div>
                    <div class="col-xs-6 bold">
                        @{{user.role.level}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>