<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'INTAMAS') }} | Admin Panel</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/plugins/iCheck/flat/blue.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/backend/plugins/datepicker/datepicker3.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('css/backend/plugins/daterangepicker/daterangepicker.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('css/backend/plugins/colorpicker/bootstrap-colorpicker.min.css') }}"/>
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
            src="{{ asset('js/backend/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
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
<body class="hold-transition skin-purple sidebar-mini sidebar-collapsee">
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
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>INTAMAS</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Asset Admin</b> Panel</span>
        </a>


        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->

                    <!-- Notifications: style can be found in dropdown.less -->

                    <!-- Tasks: style can be found in dropdown.less -->

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu"><a href="#" class="dropdown-toggle"> <img
                                src="{{ URL::to('/') }}/img/User-Avatar.png" class="user-image"
                                alt="User Image"> <span
                                class="hidden-xs">{{ Auth::guard('admin')->user()->name }}</span> </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header"><img
                                    src="{{ URL::to('/') }}/img/User-Avatar.png"
                                    class="img-circle" alt="User Image">
                                <p> {{ Auth::guard('admin')->user()->name }}</p>
                            </li>
                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('admin.editPassword') }}"
                                       class="btn btn-default btn-flat">Change Password</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat" onclick="">Sign
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
                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-permissions-create', 'admin-permissions-read', 'admin-permissions-update', 'admin-permissions-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.admin-permissions.create', 'admin.admin-permissions.index', 'admin.admin-permissions.edit']) }}">
                        <a href="#">
                            <i class="fa fa-key"></i> <span>Admin Permissions</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-permissions-create'))
                                <li class="{{ Helper::menuIsActive(['admin.admin-permissions.create']) }}">
                                    <a href="{{ route('admin.admin-permissions.create') }}"><i
                                            class="fa fa-plus-square"></i> New</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-permissions-read'))
                                <li class="{{ Helper::menuIsActive(['admin.admin-permissions.index']) }}">
                                    <a href="{{ route('admin.admin-permissions.index') }}"><i class="fa fa-list"></i>
                                        List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-admins-create', 'admin-admins-read', 'admin-admins-update', 'admin-admins-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.admins.create', 'admin.admins.index', 'admin.admins.edit', 'admin.admins.resetPassword']) }}">
                        <a href="#">
                            <i class="fa fa-user-secret"></i> <span>Admins</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-admins-create'))
                                <li class="{{ Helper::menuIsActive(['admin.admins.create']) }}">
                                    <a href="{{ route('admin.admins.create') }}"><i class="fa fa-plus-square"></i> New
                                        Admin</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-admins-read'))
                                <li class="{{ Helper::menuIsActive(['admin.admins.index']) }}">
                                    <a href="{{ route('admin.admins.index') }}"><i class="fa fa-list"></i> Admin
                                        List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-permissions-create', 'admin-client-permissions-read', 'admin-client-permissions-update', 'admin-client-permissions-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.client-permissions.create', 'admin.client-permissions.index', 'admin.client-permissions.edit']) }}">
                        <a href="#">
                            <i class="fa fa-lock"></i> <span>Client Permissions</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-client-permissions-create'))
                                <li class="{{ Helper::menuIsActive(['admin.client-permissions.create']) }}">
                                    <a href="{{ route('admin.client-permissions.create') }}"><i
                                            class="fa fa-plus-square"></i> New</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-client-permissions-read'))
                                <li class="{{ Helper::menuIsActive(['admin.client-permissions.index']) }}">
                                    <a href="{{ route('admin.client-permissions.index') }}"><i class="fa fa-list"></i>
                                        List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-clients-create', 'admin-clients-read', 'admin-clients-update', 'admin-clients-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.clients.create', 'admin.clients.index', 'admin.clients.edit', 'admin.clients.show', 'admin.client-roles.create', 'admin.client-roles.index', 'admin.client-roles.edit']) }}">
                        <a href="#">
                            <i class="fa fa-industry"></i> <span>Clients</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-clients-create'))
                                <li class="{{ Helper::menuIsActive(['admin.clients.create']) }}">
                                    <a href="{{ route('admin.clients.create') }}"><i class="fa fa-plus-square"></i> New
                                        Client</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-clients-read'))
                                <li class="{{ Helper::menuIsActive(['admin.clients.index']) }}">
                                    <a href="{{ route('admin.clients.index') }}"><i class="fa fa-list"></i> Client List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-client-users-create', 'admin-client-users-read', 'admin-client-users-update', 'admin-client-users-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.client-users.create', 'admin.client-users.index', 'admin.client-users.edit', 'admin.client-users.resetPassword']) }}">
                        <a href="#">
                            <i class="fa fa-users"></i> <span>Client Users</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-client-users-create'))
                                <li class="{{ Helper::menuIsActive(['admin.client-users.create']) }}">
                                    <a href="{{ route('admin.client-users.create') }}"><i class="fa fa-plus-square"></i>
                                        New Client User</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-client-users-read'))
                                <li class="{{ Helper::menuIsActive(['admin.client-users.index']) }}">
                                    <a href="{{ route('admin.client-users.index') }}"><i class="fa fa-list"></i> Client
                                        User List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-permissions-create', 'admin-vendor-permissions-read', 'admin-vendor-permissions-update', 'admin-vendor-permissions-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.vendor-permissions.create', 'admin.vendor-permissions.index', 'admin.vendor-permissions.edit']) }}">
                        <a href="#">
                            <i class="fa fa-unlock-alt"></i> <span>Vendor Permissions</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendor-permissions-create'))
                                <li class="{{ Helper::menuIsActive(['admin.vendor-permissions.create']) }}">
                                    <a href="{{ route('admin.vendor-permissions.create') }}"><i
                                            class="fa fa-plus-square"></i> New</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendor-permissions-read'))
                                <li class="{{ Helper::menuIsActive(['admin.vendor-permissions.index']) }}">
                                    <a href="{{ route('admin.vendor-permissions.index') }}"><i class="fa fa-list"></i>
                                        List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendor-infos-create', 'admin-vendor-infos-read', 'admin-vendor-infos-update', 'admin-vendor-infos-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.vendors.create', 'admin.vendors.index', 'admin.vendors.edit','admin.vendor-roles.index','admin.vendor-roles.edit']) }}">
                        <a href="#">
                            <i class="fa fa-gears"></i> <span>Vendors</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendor-infos-create'))
                                <li class="{{ Helper::menuIsActive(['admin.vendors.create']) }}">
                                    <a href="{{ route('admin.vendors.create') }}"><i class="fa fa-plus-square"></i>
                                        New Vendor</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendor-infos-read'))
                                <li class="{{ Helper::menuIsActive(['admin.vendors.index']) }}">
                                    <a href="{{ route('admin.vendors.index') }}"><i class="fa fa-list"></i> Vendors
                                        List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-vendors-create', 'admin-vendors-read', 'admin-vendors-update', 'admin-vendors-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.vendor-users.create', 'admin.vendor-users.index', 'admin.vendor-users.edit', 'admin.vendor-users.resetPassword']) }}">
                        <a href="#">
                            <i class="fa fa-users"></i> <span>Vendor Users</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendors-create'))
                                <li class="{{ Helper::menuIsActive(['admin.vendor-users.create']) }}">
                                    <a href="{{ route('admin.vendor-users.create') }}"><i class="fa fa-plus-square"></i> New
                                        Vendor User</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendors-read'))
                                <li class="{{ Helper::menuIsActive(['admin.vendor-users.index']) }}">
                                    <a href="{{ route('admin.vendor-users.index') }}"><i class="fa fa-list"></i> Vendor Users
                                        List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-categories-create', 'admin-asset-categories-read', 'admin-asset-categories-update', 'admin-asset-categories-delete', 'admin-asset-categories-pending', 'admin-asset-categories-approved']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.asset-categories.create', 'admin.asset-categories.index', 'admin.asset-categories.edit', 'admin.asset-categories.pending']) }}">
                        <a href="#">
                            <i class="fa fa-list"></i> <span>Asset Categories</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-categories-create'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-categories.create']) }}">
                                    <a href="{{ route('admin.asset-categories.create') }}"><i
                                            class="fa fa-plus-square"></i> New Category</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-categories-read'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-categories.index']) }}">
                                    <a href="{{ route('admin.asset-categories.index') }}"><i class="fa fa-list"></i>
                                        Category List</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-categories-pending'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-categories.pending']) }}">
                                    <a href="{{ route('admin.asset-categories.pending') }}"><i class="fa fa-list"></i>
                                        Pending Category</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-subcategories-create', 'admin-asset-subcategories-read', 'admin-asset-subcategories-update', 'admin-asset-subcategories-delete', 'admin-asset-subcategories-pending', 'admin-asset-subcategories-approved']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.asset-subcategories.create', 'admin.asset-subcategories.index', 'admin.asset-subcategories.edit', 'admin.asset-subcategories.pending']) }}">
                        <a href="#">
                            <i class="fa fa-list-alt"></i> <span>Asset Sub Categories</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-subcategories-create'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-subcategories.create']) }}">
                                    <a href="{{ route('admin.asset-subcategories.create') }}"><i
                                            class="fa fa-plus-square"></i> New Sub Category</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-subcategories-read'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-subcategories.index']) }}">
                                    <a href="{{ route('admin.asset-subcategories.index') }}"><i class="fa fa-list"></i>
                                        Sub Category List</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-subcategories-pending'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-subcategories.pending']) }}">
                                    <a href="{{ route('admin.asset-subcategories.pending') }}"><i
                                            class="fa fa-list"></i> Pending Sub Category</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-brands-create', 'admin-asset-brands-read', 'admin-asset-brands-update', 'admin-asset-brands-delete', 'admin-asset-brands-pending', 'admin-asset-brands-approved']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.asset-brands.create', 'admin.asset-brands.index', 'admin.asset-brands.edit', 'admin.asset-brands.pending']) }}">
                        <a href="#">
                            <i class="fa fa-bullseye"></i> <span>Asset Brands</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-brands-create'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-brands.create']) }}">
                                    <a href="{{ route('admin.asset-brands.create') }}"><i class="fa fa-plus-square"></i>
                                        New Brand</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-brands-read'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-brands.index']) }}">
                                    <a href="{{ route('admin.asset-brands.index') }}"><i class="fa fa-list"></i> Brand
                                        List</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-brands-pending'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-brands.pending']) }}">
                                    <a href="{{ route('admin.asset-brands.pending') }}"><i class="fa fa-list"></i>
                                        Pending Brand</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-statuses-create', 'admin-asset-statuses-read', 'admin-asset-statuses-update', 'admin-asset-statuses-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.asset-statuses.create', 'admin.asset-statuses.index', 'admin.asset-statuses.edit']) }}">
                        <a href="#">
                            <i class="fa fa-bullhorn"></i> <span>Asset Statuses</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-statuses-create'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-statuses.create']) }}">
                                    <a href="{{ route('admin.asset-statuses.create') }}"><i
                                            class="fa fa-plus-square"></i> New Status</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-statuses-read'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-statuses.index']) }}">
                                    <a href="{{ route('admin.asset-statuses.index') }}"><i class="fa fa-list"></i>
                                        Status List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-services-create', 'admin-asset-services-read', 'admin-asset-services-update', 'admin-asset-services-delete', 'admin-asset-services-pending', 'admin-asset-services-approved']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.asset-services.create', 'admin.asset-services.index', 'admin.asset-services.edit', 'admin.asset-services.pending']) }}">
                        <a href="#">
                            <i class="fa fa-wrench"></i> <span>Asset Services</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-services-create'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-services.create']) }}">
                                    <a href="{{ route('admin.asset-services.create') }}"><i
                                            class="fa fa-plus-square"></i> New Service</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-services-read'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-services.index']) }}">
                                    <a href="{{ route('admin.asset-services.index') }}"><i class="fa fa-list"></i>
                                        Service List</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-services-pending'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-services.pending']) }}">
                                    <a href="{{ route('admin.asset-services.pending') }}"><i class="fa fa-list"></i>
                                        Pending Service</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-hardwares-create', 'admin-asset-hardwares-read', 'admin-asset-hardwares-update', 'admin-asset-hardwares-delete', 'admin-asset-hardwares-pending', 'admin-asset-hardwares-approved']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.asset-accessories.create', 'admin.asset-accessories.index', 'admin.asset-accessories.edit', 'admin.asset-accessories.pending']) }}">
                        <a href="#">
                            <i class="fa fa-desktop"></i> <span>Asset Accessories</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-hardwares-create'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-accessories.create']) }}">
                                    <a href="{{ route('admin.asset-accessories.create') }}"><i
                                            class="fa fa-plus-square"></i> New Accessory</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-hardwares-read'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-accessories.index']) }}">
                                    <a href="{{ route('admin.asset-accessories.index') }}"><i class="fa fa-list"></i>
                                        Accessory List</a>
                                </li>
                            @endif
                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-hardwares-pending'))
                                <li class="{{ Helper::menuIsActive(['admin.asset-accessories.pending']) }}">
                                    <a href="{{ route('admin.asset-accessories.pending') }}"><i class="fa fa-list"></i>
                                        Pending Accessory</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-read']))
                    <li class="treeview {{ Helper::menuIsActive([ 'admin.assets.index', 'admin.assets.archive']) }}">
                        <a href="#">
                            <i class="fa fa-th-list"></i> <span>Assets</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            <li class="treeview {{ Helper::menuIsActive(['admin.assets.index']) }}">
                                <a href="{{ route('admin.assets.index') }}">
                                    <i class="fa fa fa-list"></i> <span>Asset List</span>
                                </a>
                            </li>
                            <li class="treeview {{ Helper::menuIsActive(['admin.assets.archive']) }}">
                                <a href="{{ route('admin.assets.archive') }}">
                                    <i class="fa fa fa-list"></i> <span>Asset Archive</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-assessments-read']))
                    <li class="treeview {{ Helper::menuIsActive(['admin.assessments.index', 'admin.assessments.timeline']) }}">
                        <a href="{{ route('admin.assessments.index') }}">
                            <i class="fa fa-square"></i> <span>Assessment List</span>
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
        });


    });
</script>

@yield('scripts')
</body>
</html>
