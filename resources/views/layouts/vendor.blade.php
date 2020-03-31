<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'INTAMAS') }} | Vendor Panel</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/plugins/iCheck/flat/blue.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/plugins/datepicker/datepicker3.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('css/backend/plugins/daterangepicker/daterangepicker.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('css/backend/plugins/timepicker/bootstrap-timepicker.min.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('css/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/plugins/iCheck/all.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/plugins/select2/select2.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/AdminLTE.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/skins/_all-skins.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/custom.css') }}"/>

    <link href="{{ URL::to('/') }}/favicon.png" type="image/x-icon" rel="icon"/>
    <link href="{{ URL::to('/') }}/favicon.png" type="image/x-icon" rel="shortcut icon"/>

    <script type="text/javascript" src="{{ asset('js/backend/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/bootstrap/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('js/backend/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('js/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/plugins/fastclick/fastclick.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('js/backend/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/plugins/iCheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/backend/app.min.js') }}"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"/>

@yield('header')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-green sidebar-mini"> {{--sidebar-collapse--}}
<!-- Loader -->
<div class="loader">
    <div class="ajax-content">
        <div class="spinner-border text-info"></div>
    </div>
</div>
<!-- /Loader -->
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->

        <a href="{{ route('vendor.dashboard') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>INTAMAS</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Asset Vendor</b> Panel</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span>
            </a>
            <span class="client-name">{{ Auth::guard('vendor')->user()->vendorInfo->name }}</span>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->

                    <!-- Notifications: style can be found in dropdown.less -->

                    <!-- Tasks: style can be found in dropdown.less -->

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu"><a href="#" class="dropdown-toggle"> <img
                                src="{{ URL::to('/') }}/img/User-Avatar.png" class="user-image"
                                alt="User Image"> <span
                                class="hidden-xs">{{ Auth::guard('vendor')->user()->name }}</span> </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header"><img
                                    src="{{ URL::to('/') }}/img/User-Avatar.png"
                                    class="img-circle" alt="User Image">
                                <p> {{ Auth::guard('vendor')->user()->name }}</p>
                                <small> <strong>Vendor: </strong>{{ Auth::guard('vendor')->user()->vendorInfo->name }}
                                </small>
                            </li>
                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('vendor.editPassword') }}"
                                       class="btn btn-default btn-flat">Change Password</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('vendor.logout') }}" class="btn btn-default btn-flat" onclick="">Sign
                                        out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->

                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-vendor-roles-create', 'vendor-vendor-roles-read', 'vendor-vendor-roles-update', 'vendor-vendor-roles-delete']))
                    <li class="treeview {{ Helper::menuIsActive(['vendor.vendor-roles.create', 'vendor.vendor-roles.index', 'vendor.vendor-roles.edit']) }}">
                        <a href="#">
                            <i class="fa fa-key"></i> <span>Roles</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-vendor-roles-create'))
                                <li class="{{ Helper::menuIsActive(['vendor.vendor-roles.create']) }}">
                                    <a href="{{ route('vendor.vendor-roles.create') }}"><i
                                            class="fa fa-plus-square"></i> New Role</a>
                                </li>
                            @endif
                            @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-vendor-roles-read'))
                                <li class="{{ Helper::menuIsActive(['vendor.vendor-roles.index']) }}">
                                    <a href="{{ route('vendor.vendor-roles.index') }}"><i
                                            class="fa fa-list"></i> Role List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-users-create','vendor-users-read', 'vendor-users-update', 'vendor-users-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'vendor.vendors.create', 'vendor.vendors.index', 'vendor.vendors.edit', 'vendor.vendors.show']) }}">
                        <a href="#">
                            <i class="fa fa-users"></i> <span>Vendor Users</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-users-create'))
                                <li class="{{ Helper::menuIsActive(['vendor.vendors.create']) }}">
                                    <a href="{{ route('vendor.vendors.create') }}"><i class="fa fa-plus-square"></i> New
                                        User</a>
                                </li>
                            @endif
                            @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-users-read']))
                                <li class="{{ Helper::menuIsActive(['vendor.vendors.index']) }}">
                                    <a href="{{ route('vendor.vendors.index') }}"><i class="fa fa-list"></i> Vendor
                                        Users
                                        List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-clients-read']))
                    <li class="treeview {{ Helper::menuIsActive(['vendor.clients.index', 'vendor.clients.show', 'vendor.assessments.index', 'vendor.assessments.services', 'vendor.assessments.edit']) }}">
                        <a href="{{ route('vendor.clients.index') }}">
                            <i class="fa fa-building"></i> <span>Clients</span>
                        </a>
                    </li>
                @endif

            </ul>
        </section>
    </aside>
    <!-- Left side column. contains the logo and sidebar -->

    <!-- Content Wrapper. Contains page content -->

    <style type="text/css">

        .sorting_desc i {
            float: right;
            padding-top: 3px;
        }

        .sorting_asc i {
            float: right;
            padding-top: 3px;
        }

        .sorting i {
            float: right;
            padding-top: 3px;
        }

        .table-responsive > .table > tbody > tr > th {
            white-space: normal;
        }

    </style>


@yield('content')

<!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs"></div>
        <strong>Developed by <a href="http://annanovas.com">AnnaNovas IT LTD</a>.</strong>
    </footer>

    <!-- Control Sidebar -->

    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script>
    $.widget.bridge('uibutton', $.ui.button);
    $(document).ready(function () {
        $('.dropdown.user.user-menu').hover(function (e) {
            e.preventDefault();
            $(this).toggleClass('open');
        })
    });
</script>

@yield('scripts')
</body>
</html>
