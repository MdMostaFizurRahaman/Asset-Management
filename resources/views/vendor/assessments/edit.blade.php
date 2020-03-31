@extends('layouts.vendor')

@section('content')

<div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Edit Client Assesment </h1>
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
                        <h3 class="box-title">Edit Client Assesment Info</h3>
                    </div>

                    @include('include.error')

                    {!! Form::model($assessment, ['method'=>'PATCH', 'action'=>['vendor\AssessmentController@update', $client, $assessment->id]]) !!}

                    <div class="box-body">
                        
                        <div class="col-md-6">

                            <div class="form-group">
                                {!! Form::label('asset_id', 'Asset') !!}
                                {!! Form::select('asset_id', [''=>'Choose an option']+$assets, null, ['class'=>'form-control']) !!}
                            </div>
                            
                            <div class="form-group">
                                {!! Form::label('required_days', 'Required Days') !!}
                                {!! Form::text('required_days', null, ['class'=>'form-control']) !!}
                            </div>
                            
                            <div class="form-group">
                                {!! Form::label('cost', 'Cost') !!}
                                {!! Form::text('cost', null, ['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                {!! Form::label('note', 'Note') !!}
                                {!! Form::textarea('note', null, ['class'=>'form-control', 'size' => '30x4']) !!}
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
        
        $("#asset_id").select2({
            placeholder: "Choose an option"
        });
        
        $('input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });

</script>

@endsection