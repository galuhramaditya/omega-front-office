<div class="row display-hide" id="select-display">
    <div class="col-xs-6 text-center">
        <div class="btn-group">
            <button class="btn red" v-on:click.prevent="report.handle_display({based_on : 'player_status', by : 'player'})"><i class="fa fa-user-o"></i> Player by Player Status</button>
            <button class="btn green-jungle" v-on:click.prevent="report.handle_display({based_on : 'player_status', by : 'amount'})"><i class="fa fa-user-o"></i> Amount by Player Status</button>
        </div>
    </div>
    <div class="col-xs-6 text-center">
        <div class="btn-group">
            <button class="btn grey-mint" v-on:click.prevent="report.handle_display({based_on : 'gender', by : 'player'})"><i class="fa fa-venus-mars"></i> Player by Gender</button>
            <button class="btn purple" v-on:click.prevent="report.handle_display({based_on : 'gender', by : 'amount'})"><i class="fa fa-venus-mars"></i> Amount by Gender</button>
        </div>
    </div>
</div>