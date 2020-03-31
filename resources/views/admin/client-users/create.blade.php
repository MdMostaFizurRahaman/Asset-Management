@extends('layouts.admin')

@section('content')

<div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Add New Client User </h1>
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
                        <h3 class="box-title">New Client User Info</h3>
                    </div>

                    @include('include.error')

                    {!! Form::open(['method'=>'POST', 'action'=>['admin\ClientUserController@store'], 'files'=>true]) !!}


                    <div class="box-body">
                        <div class="col-md-6">

                            <div class="form-group">
                                {!! Form::label('client_id', 'Client') !!}
                                {!! Form::select('client_id', [''=>'Choose an option']+$clients, null, ['class'=>'form-control']) !!}
                            </div>

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

        $("#client_id").select2({
            placeholder: "Choose an option"
        });

        $("#client_id").on("change", function (e) {
            $('#role_id')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Loading</option>');
            $('#role_id').trigger('change');

            if ($('#client_id').val() == '') {
                $('#role_id')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Choose an option</option>');
                $('#role_id').trigger('change');
            }
            else {
                $.ajax({
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", client_id: $('#client_id').val(), type:'2', role_id: $('#role_id').val(), includeAll: 1},
                    url: "{{ route('admin.client.roles') }}",
                    success: function (data) {
                        $('#role_id')
                                .find('option')
                                .remove()
                                .end()
                                .append(data);
                        $('#role_id').trigger('change');
                    }
                });
            }
        });

    });


</script>

@endsection
