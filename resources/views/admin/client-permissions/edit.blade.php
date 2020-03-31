@extends('layouts.admin')

@section('content')

<div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Edit Client Permission </h1>
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
                        <h3 class="box-title">Edit Client Permission Info</h3>
                    </div>

                    @include('include.error')

                    {!! Form::model($clientpermission, ['method'=>'PATCH', 'action'=>['admin\ClientPermissionController@update', $clientpermission->id]]) !!}

                    <div class="box-body">
                        <div class="col-md-6">

                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::checkbox('status', '1', null, ['id'=>'status', 'class'=>'form-control']) !!}
                                {!! Form::label('status', '&nbsp;Active') !!}
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    
                    
                    <div class="box-header ">
                        <h3 class="box-title"><span class="allpermissions">Permissions</span>
                            <span class="selectrevert">
                                <input type="checkbox" id="selectAll"> Select All
                                <span class="revert">
                                    <input type="checkbox" id="selectRevert"> Select Revert
                                </span>
                            </span>
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                @foreach($permissions as $permissionId=>$permission)
                                <div class="col-md-3">
                                    {!! Form::checkbox('permissions[]', $permissionId, null, ['class'=>'check', 'id'=>'permissionId' . $permissionId, in_array($permissionId, $permissioncategory)  ?  'checked' : '']) !!}
                                    {!! Form::label('permissionId' . $permissionId, $permission, ['class'=>'permissionlabel', 'style'=>'padding-left:5px;;margin-top:10px;']) !!}
                                </div>
                                @endforeach
                            </div>

                        </div>
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
        });
        
        $('#selectRevert').on('ifChecked', function (event) {
            $('.check').iCheck('toggle');
            triggeredByChild = false;
        });

        $('#selectAll').on('ifUnchecked', function (event) {
            if (!triggeredByChild) {
                $('.check').iCheck('uncheck');
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