<div class="row" id="chart" v-if="window.hasOwnProperty('dashboard')" vue-data>
    <div class="col-md-6" v-for="chart in dashboard.chart.display" :data="chart.id">
        <!-- BEGIN CHART PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <a :href="chart.link" class="caption">
                    <i class="fa fa-line-chart font-yellow"></i>
                    <span class="caption-subject bold uppercase font-yellow"> @{{chart.title}} </span>
                </a>
            </div>
            <div class="portlet-body">
                <div :class="chart.id">
                    @include('includes.loader')
                </div>
                <div :id="chart.id" class="chart">
                    <div class="no-data text-center display-hide">
                        <h4 class="title"></h4>
                        <h5 class="subtitle"></h5>
                        <div class="content bold">no data available</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CHART PORTLET-->
    </div>
</div>