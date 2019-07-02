<div class="row display-hide" id="select-display">
    <div class="col-xs-6 text-center">
        <div class="btn-group">
            <button class="btn red" v-on:click.prevent="report.handle_display({based_on : 'player_status'})"><i class="fa fa-user-o"></i> Based on Player Status</button>
            <button class="btn green-jungle" v-on:click.prevent="report.handle_display({based_on : 'gender'})"><i class="fa fa-venus-mars"></i> Based on Gender</button>
        </div>
    </div>
    <div class="col-xs-6 text-center">
        <div class="btn-group">
            <button class="btn grey-mint" v-on:click.prevent="report.handle_display({by : 'player'})"><i class="fa fa-arrows-h"></i> By Number of Player</button>
            <button class="btn purple" v-on:click.prevent="report.handle_display({by : 'amount'})"><i class="fa fa-arrows-v"></i> By Amount</button>
        </div>
    </div>
</div>