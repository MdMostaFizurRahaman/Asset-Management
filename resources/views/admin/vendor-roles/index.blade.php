@extends('layouts.admin')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Vendor Roles </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Vendor Info</h3>
                    </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    <!-- /.box-header -->
                    <div class="box-body table-responsive ">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th class="" style="min-width:50px;">ID</th>
                                <th class="" style="min-width:50px;">Name</th>
                                <th class="" style="min-width:50px;">Email</th>
                                <th class="" style="min-width:50px;">Phone</th>
                                <th class="" style="min-width:50px;">Status</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                            </tr>

                            <tr>
                                <td>{{ $vendorinfo->id }}</td>
                                <td>{{ $vendorinfo->name }}</td>
                                <td>{{ $vendorinfo->email }}</td>
                                <td>{{ $vendorinfo->phone }}</td>
                                <td>{!! Helper::activeVendorInfoStatusLabel($vendorinfo->status) !!}</td>
                                <td>{{ $vendorinfo->created_at->diffForHumans() }}</td>
                                <td>{{ $vendorinfo->updated_at->diffForHumans() }}</td>
                            </tr>

                        </table>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-header with-border">
                        <h3 class="box-title">Vendor Roles List</h3>
                    </div>

                    <div class="box-body table-responsive ">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th class="" style="min-width:50px;">ID</th>
                                <th class="" style="min-width:50px;">Name</th>
                                <th class="" style="min-width:50px;">Description</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                                <th style="width: 170px">Actions</th>
                            </tr>

                            @foreach($vendorinfo->roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ $role->description }}</td>
                                <td>{{ $role->created_at->diffForHumans() }}</td>
                                <td>{{ $role->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if($role->name <> 'admin')
                                    @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendor-roles-update'))
                                    <a href="{{ route('admin.vendor-roles.edit', [$vendorinfo->id, $role->id]) }}" class="btn btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendor-roles-delete'))
                                    <a href="#" class="btn btn-default btn-sm" title="Delete"
                                       onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $role->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>

                                    {!! Form::open(['method'=>'DELETE', 'action'=>['admin\VendorRoleController@destroy', $vendorinfo->id, $role->id], 'id'=>'deleteForm'.$role->id]) !!}
                                    {!! Form::close() !!}
                                    @endif
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                        </table>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-header with-border">
                        <h3 class="box-title">New Vendor Role</h3>
                    </div>

                    {!! Form::open(['method'=>'POST', 'action'=>['admin\VendorRoleController@store', $vendorinfo->id]]) !!}

                    <div class="box-body">
                        <div class="col-md-6">

                            <div class="form-group">
                                {!! Form::label('display_name', 'Name') !!}
                                {!! Form::text('display_name', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('description', 'Description') !!}
                                {!! Form::textarea('description', null, ['class'=>'form-control', 'size' => '30x4']) !!}
                            </div>
                        </div>

                    </div>

                    <div class="box-header ">
                        <h3 class="box-title"><span class="allpermissions">All Permissions</span>
                            <span class="selectrevert">
                                <input type="checkbox" id="selectAll"> Select All
                                <span class="revert">
                                    <input type="checkbox" id="selectRevert"> Select Revert
                                </span>
                            </span>
                        </h3>
                    </div>

                    @foreach($categories as $category)
                    <div class="box-header">
                        <h3 class="box-title"><span class="permissionscategory">{{ $category->name }}</span>
                            <span class="selectrevert"><input type="checkbox" class="selectcategory"> Select All</span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                @foreach($category->permissions as $permission)
                                <div class="col-md-3">
                                    {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=>'check', 'id'=>'permissionId' . $permission->id]) !!}
                                    {!! Form::label('permissionId' . $permission->id, $permission->display_name, ['class'=>'permissionlabel', 'style'=>'padding-left:5px;']) !!}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    {!! Form::close() !!}

                </div>
                <!-- /.box -->

                <!-- /.box -->
            </div>
            <!-- /.col -->

            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
    <!-- /.content -->
</div>

@endsection

@section('scripts')

<script>

    $(function () {

        var triggeredByChild = false;

        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });


        $('#selectAll').on('ifChecked', function (event) {
            $('.check').iCheck('check');
            triggeredByChild = false;
            $('#selectRevert').iCheck('uncheck');
            $('.selectcategory').iCheck('check');
        });

        $('#selectAll').on('ifUnchecked', function (event) {
            if (!triggeredByChild) {
                $('.check').iCheck('uncheck');
                $('.selectcategory').iCheck('uncheck');
            }
            triggeredByChild = false;
        });
        // Removed the checked state from "All" if any checkbox is unchecked
        $('.check').on('ifUnchecked', function (event) {
            triggeredByChild = true;
            $('#selectAll').iCheck('uncheck');
        });

        $('.check').on('ifChecked', function (event) {
            if ($('.check').filter(':checked').length == $('.check').length) {
                $('#selectAll').iCheck('check');
            }
        });

        $('#selectRevert').on('ifChecked', function (event) {
            $('.check').iCheck('toggle');
            triggeredByChild = false;
            $('.selectcategory').iCheck('uncheck');
        });

        $('.selectcategory').on('ifChecked', function (event) {
            $(this).parent().parent().parent().parent().next().find('.check').iCheck('check');
            triggeredByChild = false;
        });

        $('.selectcategory').on('ifUnchecked', function (event) {
            if (!triggeredByChild) {
                $(this).parent().parent().parent().parent().next().find('.check').iCheck('uncheck');
            }
            triggeredByChild = false;
        });

    });

</script>

@endsection
