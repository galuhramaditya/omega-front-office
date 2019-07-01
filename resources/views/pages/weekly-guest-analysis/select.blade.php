<div class="row" vue-data>
    <div class="col-md-12">
        <div class="portlet light form-fit bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-filter font-green"></i>
                    <span class="caption-subject font-green bold uppercase">Data Filtering</span>
                </div>
            </div>
            <div class="portlet-body form">
                <form class="form-horizontal form-row-seperated" v-on:submit.prevent="report.refresh_report()">
                    <div class="form-body">
                        <div class="form-group">
                            <label class="col-md-3 control-label">Outlet</label>
                            <div class="col-md-5">
                                <select name="outlet" class="bs-select form-control">
                                    <option v-for="outlet in report.outlet" :value="outlet.outletcd" :name="outlet.outletnm">@{{ outlet.outletcd }} - @{{ outlet.outletnm }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Date Range</label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="date">
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green">
                                    <i class="fa fa-check"></i> Submit
                                </button>
                                <button type="button" class="btn default">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>