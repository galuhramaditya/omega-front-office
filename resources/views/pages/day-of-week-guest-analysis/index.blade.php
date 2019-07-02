@extends('layouts.app')

@section("css")
    <link href="/assets/css/dangrossman-daterangepicker.css" rel="stylesheet" type="text/css" />
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
        @include("pages.day-of-week-guest-analysis.filter")
        <!-- LOADER -->
        @include("includes.loader")
        <!-- END LOADER -->
        <div class="on-print">
            @include("pages.day-of-week-guest-analysis.table")
            @include("pages.day-of-week-guest-analysis.chart")
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection

@section('scripts')
    <script src="/assets/scripts/global/dangrossman-daterangepicker.js" type="text/javascript"></script>
    <script src="/assets/scripts/pages/day-of-week-guest-analysis.js" type="text/javascript"></script>
@endsection