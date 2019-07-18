<div class="row" vue-data>
    <div class="col-md-12" id="table">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-table font-dark"></i>
                    <span class="caption-subject bold uppercase font-dark">Day of Week Guest Analysis</span>
                </div>
            </div>
            <div class="portlet-body table-scrollable">
                <table class="table table-striped table-bordered table-hover order-column">
                    <thead>
                        <tr>
                            <th rowspan="3">Daf Of Week</th>
                            <th colspan="8">No of Player</th>
                            <th rowspan="3">Total</th>
                            <th rowspan="3">Avg</th>
                            <th colspan="8">Amount</th>
                            <th rowspan="3">Total</th>
                            <th rowspan="3">Avg</th>
                        </tr>
                        <tr>
                            <th colspan="4">Member</th>
                            <th colspan="4">Guest</th>
                            <th colspan="4">Member</th>
                            <th colspan="4">Guest</th>
                        </tr>
                        <tr>
                            <th>AM</th>
                            <th>PM</th>
                            <th>Total</th>
                            <th>%</th>
                            <th>AM</th>
                            <th>PM</th>
                            <th>Total</th>
                            <th>%</th>
                            <th>AM</th>
                            <th>PM</th>
                            <th>Total</th>
                            <th>%</th>
                            <th>AM</th>
                            <th>PM</th>
                            <th>Total</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody class="text-right">
                        <tr v-for="(value, index) in report.reports">
                            <td class="text-left">@{{value.dayname}}</td>
                            <td>@{{report.output("nofmbram", index)}}</td>
                            <td>@{{report.output("nofmbrpm", index)}}</td>
                            <td>@{{report.output("nofmbrtotal", index)}}</td>
                            <td>@{{report.output("nofmbrprctg", index, true)}}</td>
                            <td>@{{report.output("nofgstam", index)}}</td>
                            <td>@{{report.output("nofgstpm", index)}}</td>
                            <td>@{{report.output("nofgsttotal", index)}}</td>
                            <td>@{{report.output("nofgstprctg", index, true)}}</td>
                            <td>@{{report.output("noftotal", index)}}</td>
                            <td>@{{report.output("nofavrg", index, true)}}</td>
                            <td>@{{report.output("mbramtam", index)}}</td>
                            <td>@{{report.output("mbramtpm", index)}}</td>
                            <td>@{{report.output("mbramttotal", index)}}</td>
                            <td>@{{report.output("mbramtprctg", index, true)}}</td>
                            <td>@{{report.output("gstamtam", index)}}</td>
                            <td>@{{report.output("gstamtpm", index)}}</td>
                            <td>@{{report.output("gstamttotal", index)}}</td>
                            <td>@{{report.output("gstamtprctg", index, true)}}</td>
                            <td>@{{report.output("amttotal", index)}}</td>
                            <td>@{{report.output("amtavrg", index, true)}}</td>
                        </tr>
                        <tr id="total" class="active bold">
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <img id="thumbnail_img" />
</div>