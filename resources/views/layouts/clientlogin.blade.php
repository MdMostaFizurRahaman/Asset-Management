<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'AMP') }} | Client Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/bootstrap/css/bootstrap.min.css') }}"/>


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/AdminLTE.min.css') }}"/>
    <!-- iCheck -->
    {{--<link rel="stylesheet" type="text/css" href="{{ asset('css/backend/plugins/iCheck/square/blue.css') }}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/plugins/iCheck/square/green.css') }}"/>


    <!-- jQuery 2.2.3 -->
    <script type="text/javascript" src="{{ asset('js/backend/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

    <!-- Bootstrap 3.3.6 -->
    <script type="text/javascript" src="{{ asset('js/backend/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- iCheck -->
    <script type="text/javascript" src="{{ asset('js/backend/plugins/iCheck/icheck.min.js') }}"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ route('client.dashboard', $subdomain) }}"><b>{{ $client->name ? $client->name : 'Client Name' }}</b>
            <br>{{ config('app.name', 'Laravel') }}
        </a>
    </div>
    <!-- /.login-logo -->

@yield('content')

<!-- /.login-box-body -->
</div>
<!-- /.login-box -->

@yield('scripts')

</body>
</html>




