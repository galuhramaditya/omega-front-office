@extends('layouts.app')

@section('css')
    <link href="/assets/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
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
        @include("pages.player-in-house.filter")
        <!-- LOADER -->
        @include("includes.loader")
        <!-- END LOADER -->
        <div id="on-print">
            @include("pages.player-in-house.summary")
            @include("pages.player-in-house.detail")
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection

@section('scripts')
    <script src="/assets/scripts/global/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="/assets/scripts/pages/player-in-house.js" type="text/javascript"></script>
@endsection