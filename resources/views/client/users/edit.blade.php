@extends('layouts.client')

@section('content')

<div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Edit User </h1>
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
                        <h3 class="box-title">Edit User Info</h3>
                    </div>

                    @include('include.error')

                    {!! Form::model($user, ['method'=>'PATCH', 'action'=>['client\UserController@update', $subdomain, $user->id]]) !!}

                    <div class="box-body">
                        <div class="col-md-6">

                            <div class="form-group">
                                {!! Form::label('company_id', 'Company') !!}
                                {!! Form::select('company_id', [''=>'Choose an option']+$companies, null, ['class'=>'form-control multiple']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('division_id', 'Division') !!}
                                {!! Form::select('division_id', [''=>'Choose an option']+$divisions, null, ['class'=>'form-control multiple']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('department_id', 'Department') !!}
                                {!! Form::select('department_id', [''=>'Choose an option']+$departments, null, ['class'=>'form-control multiple']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('unit_id', 'Unit') !!}
                                {!! Form::select('unit_id', [''=>'Choose an option']+$units, null, ['class'=>'form-control multiple']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('office_location_id', 'Office Location') !!}
                                {!! Form::select('office_location_id', [''=>'Choose an option']+$locations, null, ['class'=>'form-control multiple']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('designation_id', 'Designation') !!}
                                {!! Form::select('designation_id', [''=>'Choose an option']+$designations, null, ['class'=>'form-control multiple']) !!}
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!}
                                {!! Form::text('email', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('phone', 'Phone') !!}
                                {!! Form::text('phone', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('role_id', 'Role') !!}
                                {!! Form::select('role_id', [''=>'Choose an option']+$roles, null, ['class'=>'form-control']) !!}
                            </div>
                            
                            <div class="form-group">
                                {!! Form::checkbox('status', '1', null, ['id'=>'status', 'class'=>'form-control']) !!}
                                {!! Form::label('status', '&nbsp;Active') !!}
                            </div>
                            
                        </div>
                    </div>
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

        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });

        $("#role_id").select2({
            placeholder: "Choose an option"
        });
        
        $(".multiple").select2({
            placeholder: "Choose an option"
        });
        
    });


</script>

@endsection