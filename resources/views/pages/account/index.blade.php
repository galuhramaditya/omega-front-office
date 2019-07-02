@extends('layouts.app')

@section('content')
<!-- BEGIN CONTENT BODY -->
<div id="user">
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> Account System
    </h1>
    <!-- END PAGE TITLE-->
    
    @include('includes.alert')
    @include('pages.account.info')
    @include('pages.account.table')
</div>
<!-- END CONTENT BODY -->
@endsection

@section('scripts')
    <script src="/assets/scripts/pages/account.js" type="text/javascript"></script>
@endsection