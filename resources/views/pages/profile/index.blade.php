@extends('layouts.app')

@section('content')
<!-- BEGIN CONTENT BODY -->
<div id="user">
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">
    </h1>
    <!-- END PAGE TITLE-->

    @include('includes.alert')
    @include('pages.profile.info')

</div>
<!-- END CONTENT BODY -->
@endsection

@section('scripts')
<script src="{{ url('/assets/scripts/pages/profile.js') }}" type="text/javascript"></script>
@endsection