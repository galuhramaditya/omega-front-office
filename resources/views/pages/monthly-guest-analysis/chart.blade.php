<div class="row" id="chart" vue-data>
    <div class="col-xs-12">
        <!-- BEGIN CHART PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title" v-if="report.display != null">
                <div class="caption">
                    <i class="fa fa-line-chart font-yellow"></i>
                    <span class="caption-subject bold uppercase font-yellow"> @{{ report.chart[report.display.based_on][report.display.by].title }} </span>
                </div>
            </div>
            <div class="portlet-body">
                <div id="chart-display" class="chart"> </div>
            </div>
        </div>
        <!-- END CHART PORTLET-->
    </div>
</div>