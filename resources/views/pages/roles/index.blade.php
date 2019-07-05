@extends('layouts.app')

@section('css')
    <link href="/assets/css/bootstrap-select.min.css" rel="stylesheet" type="text/css" />    
    <style>
        .dropdown-menu li a:hover {
            background: #32c5d2;
            color: white !important;
        }
        .dropdown-menu li.selected a, .dropdown-menu li.selected a span {
            background: #32c5d2;
            color: white !important;
        }
    </style>
@endsection

@section('content')
<!-- BEGIN CONTENT BODY -->
<div id="user">
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> Role System
    </h1>
    <!-- END PAGE TITLE-->
    
    @include('includes.alert')
    @include('pages.roles.table')
</div>
<!-- END CONTENT BODY -->
@endsection

@section('scripts')
    <script src="/assets/scripts/global/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="/assets/scripts/pages/roles.js" type="text/javascript"></script>
@endsection