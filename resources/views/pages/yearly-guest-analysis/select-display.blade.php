<div class="row display-hide" id="select-display">
    <div class="col-xs-12 text-center">
        <div class="btn-group">
            <button class="btn red btn-lg" v-on:click.prevent="report.handle_charting('column')"><i class="fa fa-bar-chart"></i> Chart By Column</button>
            <button class="btn purple btn-lg" v-on:click.prevent="report.handle_charting('line')"><i class="fa fa-line-chart"></i> Chart By Line</button>
        </div>
    </div>
</div>