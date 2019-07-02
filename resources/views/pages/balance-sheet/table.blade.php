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
                    <tbody>
                        <tr v-for="(data, index) in report.reports">
                            <td style="text-align: left;" :class="data.ActNm[0] != ' ' ? 'bold' : ''">@{{data.ActNm.split(" ").join("&nbsp")}}</td>
                            <td style="text-align: right;">@{{data.ActAmt == 0 ? "" : parseFloat(data.ActAmt).toLocaleString()}}</td>
                            <td style="text-align: left;" :class="data.PasNm[0] != ' ' ? 'bold' : ''">@{{data.PasNm.split(" ").join("&nbsp")}}</td>
                            <td style="text-align: right;">@{{data.PasAmt == 0 ? "" : parseFloat(data.PasAmt).toLocaleString()}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <img id="thumbnail_img" />
</div>