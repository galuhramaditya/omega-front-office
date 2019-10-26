<div class="row" id="table" vue-data>
    <div class="col-xs-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-table font-dark"></i>
                    <span class="caption-subject bold uppercase font-dark">YTD Outlet Revenue TOP Sales</span>
                </div>
            </div>
            <div class="portlet-body table-scrollable">
                <table class="table table-bordered table-hover order-column" v-if="report.reports != null" v-for="(reports, outlet) in report.reports">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Year to Date</th>
                            <th>Month to Date</th>
                            <th>As Date</th>
                        </tr>
                    </thead>

                    <tr>
                        <td colspan="5" class="bold">@{{outlet}}</td>
                    </tr>

                    <tbody v-for="(report, key) in reports.data">
                        <tr>
                            <td colspan="5"></td>
                        </tr>
                        <tr>
                            <td colspan="5" class="bold">@{{key}}</td>
                        </tr>
                        <tr v-for="data in report.data">
                            <td>@{{data.code}}</td>
                            <td>@{{data.description}}</td>
                            <td class="text-right">@{{parseFloat(data.ytd).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                            <td class="text-right">@{{parseFloat(data.mtd).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                            <td class="text-right">@{{parseFloat(data.date).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="text-right" style="border-top: 2px solid black; border-bottom: 2px solid black">@{{parseFloat(report.total_ytd).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                            <td class="text-right" style="border-top: 2px solid black; border-bottom: 2px solid black">@{{parseFloat(report.total_mtd).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                            <td class="text-right" style="border-top: 2px solid black; border-bottom: 2px solid black">@{{parseFloat(report.total_date).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                        </tr>
                    </tbody>
                    <tr>
                        <td colspan="5"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="text-right" style="border-top: 2px solid black; border-bottom: 2px solid black">@{{parseFloat(reports.total_ytd).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                        <td class="text-right" style="border-top: 2px solid black; border-bottom: 2px solid black">@{{parseFloat(reports.total_mtd).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                        <td class="text-right" style="border-top: 2px solid black; border-bottom: 2px solid black">@{{parseFloat(reports.total_date).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <img id="thumbnail_img" />
</div>