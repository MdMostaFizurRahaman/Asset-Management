@extends('layouts.vendorlogin')

@section('content')
<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    @include('include.login_error')
    @include('include.flashMessage')
    <form action="{{ route('vendor.login.submit') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group has-feedback">
            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus placeholder="User Id">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-success btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
    <a href="{{ route('vendor.password.forgot') }}">Forgot your password?</a>

</div>
@endsection


@section('scripts')

<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
            increaseArea: '20%' // optional
        });
    });

</script>

@endsection
