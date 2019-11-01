<div class="row" id="table" vue-data>
    <div class="col-xs-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-table font-dark"></i>
                    <span class="caption-subject bold uppercase font-dark">Outlet Revenue Analysis</span>
                </div>
            </div>
            <div class="portlet-body table-scrollable" style="margin-bottom: 30px !important">
                <table class="table table-bordered table-hover order-column">
                    <thead>
                        <tr>
                            <th>Outlet</th>
                            <th>As Date</th>
                            <th>Weekly</th>
                            <th>Monthly</th>
                            <th>Yearly</th>
                        </tr>
                    </thead>

                    <tbody v-if="report.reports != null && report.reports.date != null">
                        <tr v-for="data in report.reports.date.data" v-show="data.tasdate || data.tmonthly || data.tweekly || data.tyearly">
                            <td>@{{data.descp}}</td>
                            <td class="text-right">@{{parseFloat(data.tasdate).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                            <td class="text-right">@{{parseFloat(data.tmonthly).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                            <td class="text-right">@{{parseFloat(data.tweekly).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                            <td class="text-right">@{{parseFloat(data.tyearly).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                        </tr>
                        <tr style="border-top: 2px solid black">
                            <td> Grand Total </td>
                            <td class="text-right">@{{parseFloat(report.reports.date.tasdate).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                            <td class="text-right">@{{parseFloat(report.reports.date.tweekly).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                            <td class="text-right">@{{parseFloat(report.reports.date.tmonthly).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                            <td class="text-right">@{{parseFloat(report.reports.date.tyearly).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <img id="thumbnail_img" />
</div>