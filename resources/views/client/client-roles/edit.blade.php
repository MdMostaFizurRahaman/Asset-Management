@extends('layouts.client')

@section('content')

    <div class="content-wrapper" style="">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Edit Role </h1>
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
                            <h3 class="box-title">Edit Role Info</h3>
                        </div>

                        @include('include.error')

                        {!! Form::model($role, ['method'=>'PATCH', 'action'=>['client\ClientRoleController@update', $subdomain, $role->id]]) !!}

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
                            <h3 class="box-title"><span class="allpermissions">Permissions</span>
                                <span class="selectrevert">
                                    <input type="checkbox" id="selectAll"> Select All
                                </span>
                                <span class="revert">
                                    <input type="checkbox" id="selectRevert"> Select Revert
                                </span>
                            </h3>
                        </div>

                        @if($role->name <> 'admin')
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
                                                    {!! Form::checkbox('permissions[]', $permission->id, in_array($permission->id, $role->permissions->pluck('permission_id')->all()) ? 1 : null, ['class'=>'check','id'=>'permissionId' . $permission->id]) !!}
                                                    {!! Form::label('permissionId' . $permission->id, $permission->display_name, ['class'=>'permissionlabel','style'=>'padding-left:5px;']) !!}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    <!-- /.box-body -->

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

        });


    </script>

@endsection
