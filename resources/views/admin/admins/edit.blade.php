@extends('layouts.admin')

@section('content')

<div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Edit Admin </h1>
        <ol class="breadcrumb">
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Admin Info</h3>
                    </div>

                    @include('include.error')

                    {!! Form::model($admin, ['method'=>'PATCH', 'action'=>['admin\AdminController@update', $admin->id]]) !!}

                    <div class="box-body">
                        <div class="col-md-6">

                            <div class="form-group">
                                {!! Form::label('role_id', 'Role') !!}
                                {!! Form::select('role_id', [''=>'Choose an option']+$roles, null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!}
                                {!! Form::text('email', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::checkbox('status', '1', null, ['id'=>'status', 'class'=>'form-control']) !!}
                                {!! Form::label('status', '&nbsp;Active') !!}
                            </div>

                        </div>

                    </div>
                    <!-- /.box-body -->
                    <div class="permission" @if($admin->role_id <> 2) style="display:none" @endif>
                        <div class="box-header">
                            <h3 class="box-title"><span class="allpermissions">Permissions</span>
                                <span class="selectrevert">
                                <input type="checkbox" id="selectAll"> Select All
                            </span>
                                <span class="revert">
                                <input type="checkbox" id="selectRevert"> Select Revert
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
                                        {!! Form::checkbox('permissions[]', $permission->id, in_array($permission->id, $admin->permissions->pluck('permission_id')->all()) ? 1 : null, ['class'=>'check', 'id'=>'permissionId' . $permission->id]) !!}
                                        {!! Form::label('permissionId' . $permission->id, $permission->display_name, ['class'=>'permissionlabel', 'style'=>'padding-left:5px;']) !!}
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
                <!-- Horizontal Form -->

                <!-- /.box -->
                <!-- general form elements disabled -->

                <!-- /.box -->
            </div>
            <!--/.col (right) -->
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

        $('#selectRevert').on('ifChecked', function (event) {
            $('.check').iCheck('toggle');
            $('.selectcategory').iCheck('toggle');
            triggeredByChild = false;
        });

        $('#selectAll').on('ifUnchecked', function (event) {
            if (!triggeredByChild) {
                $('.check').iCheck('uncheck');
                $('.selectcategory').iCheck('uncheck');
            }
            triggeredByChild = false;
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
        //Select 2
        $("#role_id").select2({
            placeholder: "Choose an option"
        });
        //show hide
        $('#role_id').on('change', function () {
            if (this.value == '2') {
                $(".permission").show();
            } else {
                $(".permission").hide();
            }
        });

    });

</script>

@endsection
