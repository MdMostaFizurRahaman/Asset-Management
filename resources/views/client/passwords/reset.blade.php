@extends('layouts.clientlogin')

@section('content')

<div class="login-box-body">

    <p class="login-box-msg">Reset Password</p>

    @include('include.login_error')
    @include('include.flashMessage')

    @if(session('status'))
    <div class="box-body">
        <div class="callout callout-success">
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <p>{{ session('status') }}</p>
        </div>
    </div>
    @endif

    {!! Form::open(['method'=>'POST', 'action'=>['client\ResetPasswordController@reset', $subdomain]]) !!}
    
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="form-group has-feedback">
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="Confirm Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
        <!-- /.col -->
        <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
    </div>

    {!! Form::close() !!}

</div>
@endsection