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
            <div class="portlet-body table-scrollable" style="margin-bottom: 30px !important" v-if="report.month != null">
                <table class="table table-bordered table-hover order-column">
                    <thead>
                        <tr>
                            <th rowspan="2" class="bold">Description</th>
                            <th v-for="date in report.month.daysInMonth()">@{{date}}</th>
                            <th rowspan="2">Total</th>
                        </tr>
                        <tr>
                            <th v-for="date in report.month.daysInMonth()">@{{
                                moment({year: report.month.year(), month: report.month.month(), day:date}).format("dd")
                            }}</th>
                        </tr>
                    </thead>

                    <tbody id="fb-table">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <img id="thumbnail_img" />
</div>