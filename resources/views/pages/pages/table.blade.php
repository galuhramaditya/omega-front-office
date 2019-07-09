<div class="row">
    <div class="col-md-12" vue-data> 
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered" id="table" v-if="window.hasOwnProperty('page')">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-file font-dark"></i>
                    <span class="caption-subject bold uppercase font-dark">List of pages</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                        <a class="btn green btn-outline btn-circle btn-sm" data-toggle="modal" href="#create">New Account</a>
                        @include("pages.pages.create")
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <table style="font-siz" class="table table-striped table-bordered table-hover order-column">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>URL</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="pages in _.orderBy(page.pages, 'name', 'asc')">
                            <td>@{{pages.name}}</td>
                            <td>@{{pages.url}}</td>
                            <td width="100">
                                <div class="action">
                                    <a class="btn yellow btn-icon-only" data-toggle="modal" :href=`#edit-${pages.id}`>
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @include("pages.pages.edit")
                                    <a class="btn red btn-icon-only" data-toggle="modal" :href=`#delete-${pages.id}`>
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    @include("pages.pages.delete")
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>