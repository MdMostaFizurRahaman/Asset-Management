@extends('layouts.clientlogin')

@section('content')

<div class="login-box-body">
    <p class="login-box-msg">Forgot your password?</p>

    @include('include.error')                  
    @include('include.flashMessage')

    @if(session('status'))
    <div class="box-body">
        <div class="callout callout-success">
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <p>{{ session('status') }}</p>
        </div>
    </div>
    @endif

    <form action="{{ route('client.password.email', $subdomain) }}" method="post">
        {{ csrf_field() }}
        <div class="form-group has-feedback">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-success btn-block btn-flat">Submit</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

</div>

@endsection
