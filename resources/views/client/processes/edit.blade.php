@extends('layouts.client')

@section('content')

<div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Edit Process </h1>
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
                        <h3 class="box-title">Edit Process Info</h3>
                    </div>

                    @include('include.error')

                    {!! Form::model($process, ['method'=>'PATCH', 'action'=>['client\ProcessController@update', $subdomain, $process->workflow_id, $process->id]]) !!}

                    <div class="box-body">
                        <div class="col-md-6">

                            <div class="form-group">
                                {!! Form::label('title', 'Title') !!}
                                {!! Form::text('title', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('type', 'Type') !!}
                                {!! Form::select('type', [''=>'Choose an option'] + Config::get('constants.PROCESS_TYPES'), null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group minimum_no" @if($process->type <> 3 && old('type') <> 3) style="display: none; @endif">
                                {!! Form::label('minimum_no', 'Minimum No Of User') !!}
                                {!! Form::text('minimum_no', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('process_type', 'Action For Not Complete (Rejected)') !!}
                                {!! Form::select('process_type', [''=>'Choose an option'] + Config::get('constants.PROCESS_NOT_COMPLETE_TYPES'), null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('order', 'Order') !!}
                                {!! Form::text('order', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('description', 'Description') !!}
                                {!! Form::textarea('description', null, ['class'=>'form-control', 'size' => '30x4']) !!}
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

        $("#process_type").select2({
            placeholder: "Choose an option"
        });

        $("#type").select2({
            placeholder: "Choose an option"
        });

        $('#type').on('change', function () {
            if (this.value == 3)
            {
                $(".minimum_no").show();
            } else {
                $(".minimum_no").hide();
            }
        });


    });


</script>

@endsection
