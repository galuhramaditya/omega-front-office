<div class="row" id="table" vue-data>
    <div class="col-xs-6" v-for="tab in report.table">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-table font-dark"></i>
                    <span class="caption-subject bold uppercase font-dark">@{{tab.title}}</span>
                </div>
            </div>
            <div class="portlet-body table-scrollable">
                <table class="table table-striped table-bordered table-hover order-column">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th v-for="header in tab.header">@{{header}}</th>
                        </tr>
                    </thead>
                    <tbody class="text-right">
                        <tr v-for="(data, month) in report.reports">
                            <td class="text-center">@{{month}}</td>
                            <td v-for="(val, key) in data[tab.field]">@{{report.output(key, tab.field, month)}}</td>
                        </tr>
                        <tr :id=`total-${tab.field}` class="active bold">
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <img id="thumbnail_img" />
</div>