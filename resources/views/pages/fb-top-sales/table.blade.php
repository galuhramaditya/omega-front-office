<div class="row" id="table" vue-data>
    <div class="col-xs-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-table font-dark"></i>
                    <span class="caption-subject bold uppercase font-dark">F/B Rank Sales</span>
                </div>
            </div>
            <div class="portlet-body table-scrollable" style="margin-bottom: 30px !important" v-if="report.reports != null" v-for="(reports, grp1) in report.reports">
                <table class="table table-bordered table-hover order-column">
                    <thead>
                        <tr>
                            <th class="bold">@{{grp1}}</th>
                            <th v-for="date in report.total_days">@{{date}}</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody v-for="(datas, grp2) in reports">
                        <tr>
                            <td :colspan="report.total_days + 2" class="bold"><u>@{{grp2}}</u></td>
                        </tr>
                        <tr v-for="(data, desc) in datas">
                            <td>@{{desc}}</td>
                            <td class="text-right" v-for="date in report.total_days">@{{data.data[date] != null ? parseFloat(data.data[date]).toLocaleString(undefined, { maximumFractionDigits: 2 }) : 0}}</td>
                            <td class="text-right">@{{parseFloat(data.total).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <img id="thumbnail_img" />
</div>