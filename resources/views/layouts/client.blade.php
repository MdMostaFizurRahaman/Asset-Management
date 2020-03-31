<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'INTAMAS') }} | Client Panel</title>

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
<body class="hold-transition skin-green sidebar-mini sidebar-collapsee">
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

        <a href="{{ route('client.dashboard', $subdomain) }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>INTAMAS</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Client</b> Panel</span>
        </a>

        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span>
            </a>
            <span class="client-name">{{ Auth::user()->client->name }}</span>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- Messages: style can be found in dropdown.less-->

                    <!-- Notifications: style can be found in dropdown.less -->

                    <!-- Tasks: style can be found in dropdown.less -->

                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu"><a href="javascript:void(0)" class="dropdown-toggle"> <img
                                src="{{ URL::to('/') }}/img/User-Avatar.png" class="user-image"
                                alt="User Image"> <span class="hidden-xs">{{ Auth::user()->name }}</span> </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header"><img
                                    src="{{ URL::to('/') }}/img/User-Avatar.png"
                                    class="img-circle" alt="User Image">
                                <p><a class="link-color-white"
                                      href="{{ route('client.details', $subdomain) }}">{{ Auth::user()->name }}</a></p>
                            </li>
                            <!-- Menu Body -->

                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{ route('client.editPassword', $subdomain) }}"
                                       class="btn btn-default btn-flat">Change Password</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('client.logout', $subdomain) }}" class="btn btn-default btn-flat"
                                       onclick="">Sign out</a>
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

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-client-roles-create', 'client-client-roles-read', 'client-client-roles-update', 'client-client-roles-delete']))
                    <li class="treeview {{ Helper::menuIsActive(['client.client-roles.create', 'client.client-roles.index', 'client.client-roles.edit']) }}">
                        <a href="#">
                            <i class="fa fa-key"></i> <span>Roles</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-client-roles-create'))
                                <li class="{{ Helper::menuIsActive(['client.client-roles.create']) }}">
                                    <a href="{{ route('client.client-roles.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Role</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-client-roles-read'))
                                <li class="{{ Helper::menuIsActive(['client.client-roles.index']) }}">
                                    <a href="{{ route('client.client-roles.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Role List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-companies-create', 'client-companies-read', 'client-companies-update', 'client-companies-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.companies.create', 'client.companies.index', 'client.companies.edit']) }}">
                        <a href="#">
                            <i class="fa fa-industry"></i> <span>Companies</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-companies-create'))
                                <li class="{{ Helper::menuIsActive(['client.companies.create']) }}">
                                    <a href="{{ route('client.companies.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Company</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-companies-read'))
                                <li class="{{ Helper::menuIsActive(['client.companies.index']) }}">
                                    <a href="{{ route('client.companies.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Company List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-divisions-create', 'client-divisions-read', 'client-divisions-update', 'client-divisions-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.divisions.create', 'client.divisions.index', 'client.divisions.edit']) }}">
                        <a href="#">
                            <i class="fa fa-columns"></i> <span>Divisions</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-divisions-create'))
                                <li class="{{ Helper::menuIsActive(['client.divisions.create']) }}">
                                    <a href="{{ route('client.divisions.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Division</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-divisions-read'))
                                <li class="{{ Helper::menuIsActive(['client.divisions.index']) }}">
                                    <a href="{{ route('client.divisions.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Division List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-departments-create', 'client-departments-read', 'client-departments-update', 'client-departments-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.departments.create', 'client.departments.index', 'client.departments.edit']) }}">
                        <a href="#">
                            <i class="fa fa-building-o"></i> <span>Departments</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-departments-create'))
                                <li class="{{ Helper::menuIsActive(['client.departments.create']) }}">
                                    <a href="{{ route('client.departments.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Department</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-departments-read'))
                                <li class="{{ Helper::menuIsActive(['client.departments.index']) }}">
                                    <a href="{{ route('client.departments.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Department List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-units-create', 'client-units-read', 'client-units-update', 'client-units-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.units.create', 'client.units.index', 'client.units.edit']) }}">
                        <a href="#">
                            <i class="fa fa-balance-scale"></i> <span>Units</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-units-create'))
                                <li class="{{ Helper::menuIsActive(['client.units.create']) }}">
                                    <a href="{{ route('client.units.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Unit</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-units-read'))
                                <li class="{{ Helper::menuIsActive(['client.units.index']) }}">
                                    <a href="{{ route('client.units.index', $subdomain) }}"><i class="fa fa-list"></i>
                                        Unit List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-designations-create', 'client-designations-read', 'client-designations-update', 'client-designations-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.designations.create', 'client.designations.index', 'client.designations.edit']) }}">
                        <a href="#">
                            <i class="glyphicon glyphicon-king"></i> <span>Designations</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-designations-create'))
                                <li class="{{ Helper::menuIsActive(['client.designations.create']) }}">
                                    <a href="{{ route('client.designations.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Designation</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-designations-read'))
                                <li class="{{ Helper::menuIsActive(['client.designations.index']) }}">
                                    <a href="{{ route('client.designations.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Designation List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-office-locations-create', 'client-office-locations-read', 'client-office-locations-update', 'client-office-locations-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.office-locations.create', 'client.office-locations.index', 'client.office-locations.edit']) }}">
                        <a href="#">
                            <i class="fa fa-map-marker"></i> <span>Office Locations</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-office-locations-create'))
                                <li class="{{ Helper::menuIsActive(['client.office-locations.create']) }}">
                                    <a href="{{ route('client.office-locations.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Office Location</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-office-locations-read'))
                                <li class="{{ Helper::menuIsActive(['client.office-locations.index']) }}">
                                    <a href="{{ route('client.office-locations.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Office Location List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-users-create', 'client-users-read', 'client-users-update', 'client-users-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.users.create', 'client.users.index', 'client.users.edit', 'client.users.show', 'client.users.resetPassword']) }}">
                        <a href="#">
                            <i class="fa fa-users"></i> <span>Users</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-users-create'))
                                <li class="{{ Helper::menuIsActive(['client.users.create']) }}">
                                    <a href="{{ route('client.users.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New User</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-users-read'))
                                <li class="{{ Helper::menuIsActive(['client.users.index']) }}">
                                    <a href="{{ route('client.users.index', $subdomain) }}"><i class="fa fa-list"></i>
                                        User List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-categories-create', 'client-asset-categories-read', 'client-asset-categories-update', 'client-asset-categories-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.asset-categories.create', 'client.asset-categories.index', 'client.asset-categories.edit']) }}">
                        <a href="#">
                            <i class="fa fa-list"></i> <span>Asset Categories</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-categories-create'))
                                <li class="{{ Helper::menuIsActive(['client.asset-categories.create']) }}">
                                    <a href="{{ route('client.asset-categories.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Category</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-categories-read'))
                                <li class="{{ Helper::menuIsActive(['client.asset-categories.index']) }}">
                                    <a href="{{ route('client.asset-categories.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Category List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-subcategories-create', 'client-asset-subcategories-read', 'client-asset-subcategories-update', 'client-asset-subcategories-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.asset-subcategories.create', 'client.asset-subcategories.index', 'client.asset-subcategories.edit']) }}">
                        <a href="#">
                            <i class="fa fa-list-alt"></i> <span>Asset SubCategories</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-subcategories-create'))
                                <li class="{{ Helper::menuIsActive(['client.asset-subcategories.create']) }}">
                                    <a href="{{ route('client.asset-subcategories.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Subcategory</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-subcategories-read'))
                                <li class="{{ Helper::menuIsActive(['client.asset-subcategories.index']) }}">
                                    <a href="{{ route('client.asset-subcategories.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Subcategory List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-store-create', 'client-store-read', 'client-store-update', 'client-store-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.stores.create', 'client.stores.index', 'client.stores.edit']) }}">
                        <a href="#">
                            <i class="fa fa-bank"></i> <span>Asset Stores</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-store-create'))
                                <li class="{{ Helper::menuIsActive(['client.stores.create']) }}">
                                    <a href="{{ route('client.stores.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Store</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-store-read'))
                                <li class="{{ Helper::menuIsActive(['client.stores.index']) }}">
                                    <a href="{{ route('client.stores.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Store List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-tags-create', 'client-asset-tags-read', 'client-asset-tags-update', 'client-asset-tags-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.asset-tags.create', 'client.asset-tags.index', 'client.asset-tags.edit']) }}">
                        <a href="#">
                            <i class="fa fa-tags"></i> <span>Asset Tags</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-tags-create'))
                                <li class="{{ Helper::menuIsActive(['client.asset-tags.create']) }}">
                                    <a href="{{ route('client.asset-tags.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Tag</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-tags-read'))
                                <li class="{{ Helper::menuIsActive(['client.asset-tags.index']) }}">
                                    <a href="{{ route('client.asset-tags.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Tag List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-brands-create', 'client-asset-brands-read', 'client-asset-brands-update', 'client-asset-brands-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.asset-brands.create', 'client.asset-brands.index', 'client.asset-brands.edit']) }}">
                        <a href="#">
                            <i class="fa fa-bullseye"></i> <span>Asset Brands</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-brands-create'))
                                <li class="{{ Helper::menuIsActive(['client.asset-brands.create']) }}">
                                    <a href="{{ route('client.asset-brands.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Brand</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-brands-read'))
                                <li class="{{ Helper::menuIsActive(['client.asset-brands.index']) }}">
                                    <a href="{{ route('client.asset-brands.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Brand List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-services-create', 'client-asset-services-read', 'client-asset-services-update', 'client-asset-services-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.asset-services.create', 'client.asset-services.index', 'client.asset-services.edit']) }}">
                        <a href="#">
                            <i class="fa fa-wrench"></i> <span>Asset Services</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-services-create'))
                                <li class="{{ Helper::menuIsActive(['client.asset-services.create']) }}">
                                    <a href="{{ route('client.asset-services.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Service</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-services-read'))
                                <li class="{{ Helper::menuIsActive(['client.asset-services.index']) }}">
                                    <a href="{{ route('client.asset-services.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Service List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-asset-hardwares-create', 'client-asset-hardwares-read', 'client-asset-hardwares-update', 'client-asset-hardwares-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.asset-accessories.create', 'client.asset-accessories.index', 'client.asset-accessories.edit']) }}">
                        <a href="#">
                            <i class="fa fa-desktop"></i> <span>Asset Accessories</span> <span
                                class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-hardwares-create'))
                                <li class="{{ Helper::menuIsActive(['client.asset-accessories.create']) }}">
                                    <a href="{{ route('client.asset-accessories.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Accessory</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-hardwares-read'))
                                <li class="{{ Helper::menuIsActive(['client.asset-accessories.index']) }}">
                                    <a href="{{ route('client.asset-accessories.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Accessory List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-workflows-create', 'client-workflows-read', 'client-workflows-update', 'client-workflows-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.workflows.create', 'client.workflows.index', 'client.workflows.edit', 'client.processes.create', 'client.processes.index', 'client.processes.edit', 'client.processusers-create', 'client.processusers.index']) }}">
                        <a href="#">
                            <i class="fa fa-map-signs"></i> <span>Workflows</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-workflows-create'))
                                <li class="{{ Helper::menuIsActive(['client.workflows.create']) }}">
                                    <a href="{{ route('client.workflows.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Workflow</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-workflows-read'))
                                <li class="{{ Helper::menuIsActive(['client.workflows.index']) }}">
                                    <a href="{{ route('client.workflows.index', $subdomain) }}"><i
                                            class="fa fa-list"></i> Workflow List</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-assets-create', 'client-assets-read', 'client-assets-update', 'client-assets-delete', 'client.assets.archive']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.assets.create', 'client.assets.index', 'client.assets.edit', 'client.assets.show', 'client.assets.archive']) }}">
                        <a href="#">
                            <i class="fa fa-th-list"></i> <span>Assets</span> <span class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-assets-create'))
                                <li class="{{ Helper::menuIsActive(['client.assets.create']) }}">
                                    <a href="{{ route('client.assets.create', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Asset</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-assets-read'))
                                <li class="{{ Helper::menuIsActive(['client.assets.index']) }}">
                                    <a href="{{ route('client.assets.index', $subdomain) }}"><i class="fa fa-list"></i>
                                        Asset List</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-assets-archive'))
                                <li class="{{ Helper::menuIsActive(['client.assets.archive']) }}">
                                    <a href="{{ route('client.assets.archive', $subdomain) }}"><i
                                            class="fa fa-list"></i> Asset Archives</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                <li class="treeview {{ Helper::menuIsActive(['client.assessments.pendinglist', 'client.assessments.pendingapprove', 'client.assessments.pendingreject']) }}">
                    <a href="{{ route('client.assessments.pendinglist', $subdomain) }}">
                        <i class="fa fa-clock-o"></i> <span>Pending For Approval</span>
                        <span class="pull-right-container">
                                    <span
                                        class="label label-primary pull-right">{{ Helper::pendingassessments()->count() }}</span>
                                </span>
                    </a>
                </li>

                <li class="treeview {{ Helper::menuIsActive(['client.assessments.approvelist']) }}">
                    <a href="{{ route('client.assessments.approvelist', $subdomain) }}">
                        <i class="fa fa-check"></i> <span>Approval List</span>
                    </a>
                </li>

                <li class="treeview {{ Helper::menuIsActive(['client.assessments.rejectlist']) }}">
                    <a href="{{ route('client.assessments.rejectlist', $subdomain) }}">
                        <i class="fa fa-ban"></i> <span>Rejected List</span>
                    </a>
                </li>

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-assessments-read']))
                    <li class="treeview {{ Helper::menuIsActive(['client.assessments.index', 'client.assessments.timeline']) }}">
                        <a href="{{ route('client.assessments.index', $subdomain) }}">
                            <i class="fa fa-square"></i> <span>Assessment List</span>
                        </a>
                    </li>
                @endif

                @if(Auth::user()->hasRole('admin') || Auth::user()->can(['client-vendor-enlistment-create', 'client-vendor-enlistment-read', 'client-vendor-enlistment-update', 'client-vendor-enlistment-delete']))
                    <li class="treeview {{ Helper::menuIsActive([ 'client.vendor-enlistments.create', 'client.vendor-enlistments.index', 'client.vendor-enlistments.edit', 'client.vendor-enlistments.show','client.vendor-enlistments.list','client.vendor-enlistments.asset.permission','client.vendor-enlistments.attach.file']) }}">
                        <a href="#">
                            <i class="fa fa-list-alt"></i> <span>Vendor Enlistments</span> <span
                                class="pull-right-container"> <i
                                    class="fa fa-angle-left pull-right"></i> </span>
                        </a>
                        <ul class="treeview-menu">
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-vendor-enlistment-create'))
                                <li class="{{ Helper::menuIsActive(['client.vendor-enlistments.list','client.vendor-enlistments.create']) }}">
                                    <a href="{{ route('client.vendor-enlistments.list', $subdomain) }}"><i
                                            class="fa fa-plus-square"></i> New Enlistment</a>
                                </li>
                            @endif
                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-vendor-enlistment-read'))
                                <li class="{{ Helper::menuIsActive(['client.vendor-enlistments.index']) }}">
                                    <a href="{{ route('client.vendor-enlistments.index', $subdomain) }}"><i
                                            class="fa fa-list"></i>
                                        Enlistment List</a>
                                </li>
                            @endif
                        </ul>
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
