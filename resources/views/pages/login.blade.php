@extends('layouts.login')

@section('content')
    <!-- BEGIN LOGIN FORM -->
    <form form-action="login" v-on:submit.prevent="handleLogin()">
        <h3 class="form-title font-green">Sign In</h3>
        @include('includes.alert')
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <input class="form-control" type="text" autocomplete="off" placeholder="Username" name="username" />
            <div class="help-block font-red" help-name="username"></div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <input class="form-control" type="password" autocomplete="off" placeholder="Password" name="password" />
            <div class="help-block font-red" help-name="password"></div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn green uppercase">Login</button>
        </div>
    </form>
    <!-- END LOGIN FORM -->
@endsection