@extends('layouts.admin')

@section('content')

    <div class="content-wrapper" style="">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Add New Admin </h1>
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
                            <h3 class="box-title">New Admin Info</h3>
                        </div>

                        @include('include.error')

                        {!! Form::open(['method'=>'POST', 'action'=>['admin\AdminController@store'], 'files'=>true]) !!}


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
                                    {!! Form::label('password', 'Password') !!}
                                    {!! Form::password('password', ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('password_confirmation', 'Confirm Password') !!}
                                    {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
                                </div>


                                <div class="form-group">
                                    {!! Form::checkbox('status', '1', 1, ['id'=>'status', 'class'=>'form-control']) !!}
                                    {!! Form::label('status', '&nbsp;Active') !!}
                                </div>

                            </div>

                        </div>

                        <!-- /.box-body -->
                        <div class="permission" style="display:{{ $display }}">
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
                                                    {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=>'check', 'id'=>'permissionId' . $permission->id]) !!}
                                                    {!! Form::label('permissionId' . $permission->id, $permission->display_name, ['class'=>'permissionlabel','style'=>'padding-left:5px;']) !!}
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
