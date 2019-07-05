@extends('layouts.app')

@section('content')
<!-- BEGIN CONTENT BODY -->
<div id="user">
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title"> Page System
    </h1>
    <!-- END PAGE TITLE-->
    
    @include('includes.alert')
    @include('pages.pages.table')
</div>
<!-- END CONTENT BODY -->
@endsection

@section('scripts')
    <script src="/assets/scripts/pages/pages.js" type="text/javascript"></script>
@endsection