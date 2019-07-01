<div class="btn-group">
    <button type="button" class="btn btn-xs dropdown-toggle" 
    :class="statusColor({{$data}}, 'btn')" data-toggle="dropdown"> {{<?=$data?>.status != '' ? {{$data}}.status : '-'}}
        <i class="{{$icon}}"></i>
    </button>
    <ul class="dropdown-menu pull-right" role="menu">
        <li :class="{{$data}}.status == 'Open' ? 'active' : ''">
            <a v-on:click.prevent="{{$data}}.status != 'Open' ? {{$func}}(index, 'Open') : ''">
                <i class="icon-book-open"></i> Open</a>
        </li>
        <li :class="{{$data}}.status == 'Approved' ? 'active' : ''">
            <a v-on:click.prevent="{{$data}}.status != 'Approved' ? {{$func}}(index, 'Approved') : ''">
                <i class="icon-check"></i> Approved</a>
        </li>
        <li class="divider"> </li>
        <li :class="{{$data}}.status == 'Canceled' ? 'active' : ''">
            <a v-on:click.prevent="{{$data}}.status != 'Canceled' ? {{$func}}(index, 'Canceled') : ''">
                <i class="icon-ban"></i> Canceled</a>
        </li>
        <li :class="{{$data}}.status == 'Closed' ? 'active' : ''" v-show="{{$data != "detail"}}">
            <a v-on:click.prevent="{{$data}}.status != 'Closed' ? {{$func}}(index, 'Closed') : ''">
                <i class="icon-close"></i> Closed</a>
        </li>
    </ul>
</div>