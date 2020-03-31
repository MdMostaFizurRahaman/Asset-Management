@extends('layouts.admin')

@section('content')

<div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Edit Client User </h1>
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
                        <h3 class="box-title">Edit Client User Info</h3>
                    </div>

                    @include('include.error')

                    {!! Form::model($user, ['method'=>'PATCH', 'action'=>['admin\ClientUserController@update', $user->id]]) !!}

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

    });


</script>

@endsection