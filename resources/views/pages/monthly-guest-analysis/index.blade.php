@extends('layouts.app')

@section('toolbar')
    <div class="btn-group pull-right">
        <button type="button" class="btn green btn-sm btn-outline dropdown-toggle" data-toggle="dropdown"> Actions
            <i class="fa fa-angle-down"></i>
        </button>
        <ul class="dropdown-menu pull-right" role="menu">
            <li>
                <a v-on:click.prevent="report.print()">
                    <i class="icon-bag"></i>Save as PDF</a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div id="report">
        <!-- BEGIN PAGE TITLE-->
        <h1 class="page-title"> Report System
        </h1>
        <!-- END PAGE TITLE-->
        @include("pages.monthly-guest-analysis.select")
        <!-- LOADER -->
        @include("includes.loader")
        <!-- END LOADER -->
        <div class="on-print">
            @include("pages.monthly-guest-analysis.chart")
        </div>
    </div>
    <!-- END CONTENT BODY -->
@endsection

@section('scripts')
    <script src="/assets/scripts/pages/monthly-guest-analysis.js" type="text/javascript"></script>
@endsection