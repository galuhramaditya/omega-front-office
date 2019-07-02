@extends('layouts.app')

@section('css')
    <link href="/assets/css/sensortower-daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <style>
        .daterangepicker .custom-range-inputs input {
            pointer-events: none;
        }
        #select-chart{
            margin: 50px 0; 
        }
        #select-chart .btn{
            width: 250px;
        }
    </style>
@endsection

@section('toolbar')
    <div class="btn-group pull-right">
        <button type="button" class="btn green btn-sm btn-outline" v-on:click.prevent="report.print()">
                <i class="fa fa-print"></i> Print
        </button>
    </div>
@endsection

@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div id="report">
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> Report System
        </h1>
        <!-- END PAGE TITLE-->
        @include("pages.yearly-guest-analysis.filter")
        <!-- LOADER -->
        @include("includes.loader")
        <!-- END LOADER -->
        <div class="on-print">
            @include("pages.yearly-guest-analysis.table")
        
            <div class="row display-hide" id="select-chart">
                <div class="col-xs-12 text-center">
                    <div class="btn-group">
                        <button class="btn red btn-lg" v-on:click.prevent="report.handle_charting('column')"><i class="fa fa-bar-chart"></i> Chart By Column</button>
                        <button class="btn purple btn-lg" v-on:click.prevent="report.handle_charting('line')"><i class="fa fa-line-chart"></i> Chart By Line</button>
                    </div>
                </div>
            </div>
            
            @include("pages.yearly-guest-analysis.chart")
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection

@section('scripts')
    <script src="/assets/scripts/global/knockout-3.5.0.js" type="text/javascript"></script>
    <script src="/assets/scripts/global/sensortower-daterangepicker.min.js" type="text/javascript"></script>
    <script src="/assets/scripts/pages/yearly-guest-analysis.js" type="text/javascript"></script>
@endsection