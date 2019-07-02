@extends('layouts.app')

@section('css')
    <link href="/assets/css/sensortower-daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <style>
        .daterangepicker .custom-range-inputs input {
            pointer-events: none;
        }
        #select-display{
            margin-bottom: 20px;
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
        @include("pages.monthly-guest-analysis.filter")
        <!-- LOADER -->
        @include("includes.loader")
        <!-- END LOADER -->
        <div class="on-print">
            @include("pages.monthly-guest-analysis.chart")
            @include("pages.monthly-guest-analysis.select-display")
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection

@section('scripts')
    <script src="/assets/scripts/global/knockout-3.5.0.js" type="text/javascript"></script>
    <script src="/assets/scripts/global/sensortower-daterangepicker.min.js" type="text/javascript"></script>
    <script src="/assets/scripts/pages/monthly-guest-analysis.js" type="text/javascript"></script>
@endsection