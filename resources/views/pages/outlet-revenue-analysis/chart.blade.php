<div class="row" id="chart" vue-data>
    <div class="col-xs-12" v-for="value in report.chart">
        <!-- BEGIN CHART PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i :class="`fa fa-${value.type}-chart font-yellow`"></i>
                    <span class="caption-subject bold uppercase font-yellow"> @{{ value.title }} </span>
                </div>
            </div>
            <div class="portlet-body">
                <div :id="value.id" class="chart"> </div>
            </div>
        </div>
        <!-- END CHART PORTLET-->
    </div>
</div>