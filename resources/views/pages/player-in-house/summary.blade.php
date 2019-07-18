<div class="row" id="table" vue-data>
    <div class="col-xs-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-table font-dark"></i>
                    <span class="caption-subject bold uppercase font-dark">Summary by Player Type</span>
                </div>
            </div>
            <div class="portlet-body table-scrollable">
                <table class="table table-striped table-bordered table-hover order-column" v-if="report.reports != null">
                    <thead>
                        <tr>
                            <th colspan="2">Total Flight : @{{report.reports.summary.flight}}</th>
                            <th colspan="3">Morning</th>
                            <th colspan="3">Afternoon</th>
                            <th colspan="3">Total</th>
                        </tr>
                        <tr>
                            <th>Holes</th>
                            <th>Player Type</th>
                            <th>M</th>
                            <th>F</th>
                            <th>Amount</th>
                            <th>M</th>
                            <th>F</th>
                            <th>Amount</th>
                            <th>M</th>
                            <th>F</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody class="text-right">
                        <tr v-for="(data, index) in report.reports.summary.data">
                            <td>@{{data.holes}}</td>
                            <td class="text-left">@{{index}}</td>
                            <td>@{{report.summary_output(index, "M", "male")}}</td>
                            <td>@{{report.summary_output(index, "M", "female")}}</td>
                            <td>@{{report.summary_output(index, "M", "amount")}}</td>
                            <td>@{{report.summary_output(index, "A", "male")}}</td>
                            <td>@{{report.summary_output(index, "A", "female")}}</td>
                            <td>@{{report.summary_output(index, "A", "amount")}}</td>
                            <td>@{{report.summary_output(index, "total", "male")}}</td>
                            <td>@{{report.summary_output(index, "total", "female")}}</td>
                            <td>@{{report.summary_output(index, "total", "amount")}}</td>
                        </tr>
                        <tr class="active bold" id="total"></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <img id="thumbnail_img" />
</div>