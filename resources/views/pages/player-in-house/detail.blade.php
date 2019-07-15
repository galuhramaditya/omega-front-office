<div class="row" id="table" vue-data>
    <div class="col-xs-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-table font-dark"></i>
                    <span class="caption-subject bold uppercase font-dark">Player in House</span>
                </div>
            </div>
            <div class="portlet-body table-scrollable">
                <table class="table table-striped table-bordered table-hover order-column">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Bag Tag</th>
                            <th>Hole</th>
                            <th>Type</th>
                            <th>Code</th>
                            <th>sex</th>
                            <th>First Name</th>
                            <th>Tee Tm</th>
                            <th>C/I Tm</th>
                            <th>C/O Tm</th>
                            <th>Amount</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody v-if="report.reports != null">
                        <tr v-for="(data, index) in report.reports.detail">
                            <td>@{{index + 1}}</td>
                            <td>@{{data.bagtag}}</td>
                            <td>@{{data.holes}}</td>
                            <td>@{{data.gsttype}}</td>
                            <td>@{{data.gstcd}}</td>
                            <td>@{{data.sex}}</td>
                            <td>@{{data.fstnm}}</td>
                            <td>@{{data.teetime}}</td>
                            <td>@{{data.cintime}}</td>
                            <td>@{{data.cOuttime}}</td>
                            <td>@{{parseFloat(data.orgamt1).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                            <td>@{{parseFloat(data.rmnamt1).toLocaleString(undefined, { maximumFractionDigits: 2 })}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <img id="thumbnail_img" />
</div>