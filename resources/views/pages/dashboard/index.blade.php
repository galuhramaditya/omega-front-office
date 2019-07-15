@extends('layouts.app')

@section('css')
    <style>
        #dashboard-stat a {
            margin-top: 10px;
            width: 100%;
        }
        #chart {
            margin-top: 20px;
        }
        .chart .content {
            margin: 80px 0;
        },
    </style>
@endsection

@section('content')
<!-- BEGIN CONTENT BODY -->
<div id="user">
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">
    </h1>
    <!-- END PAGE TITLE-->
    
    @include('includes.alert')
    @include('pages.dashboard.info')
    
    <div class="row" v-if="menu != null" id="dashboard-stat">
        <div class="col-lg-3 col-sm-4 col-xs-12" v-for="menu in _.orderBy(menu, 'url', 'asc')">
            <a class="btn default" :href="menu.url">
                @{{menu.name}}
            </a>
        </div>
    </div>

    @include('pages.dashboard.chart')
</div>
<!-- END CONTENT BODY -->
@endsection

@section('scripts')
    <script src="/assets/scripts/pages/dashboard.js" type="text/javascript"></script>
@endsection