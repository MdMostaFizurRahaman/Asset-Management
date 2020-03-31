@extends('layouts.admin')

@section('content')

<div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Add New Vendor </h1>
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
                        <h3 class="box-title">New Vendor Info</h3>
                    </div>

                    @include('include.error')

                    {!! Form::open(['method'=>'POST', 'action'=>'admin\VendorInfoController@store']) !!}


                    <div class="box-body">
                        <div class="col-md-6">

                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('email', 'Primary Email') !!}
                                {!! Form::text('email', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('secondary_email', 'Secondary Email') !!}
                                {!! Form::text('secondary_email', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('phone', 'Phone') !!}
                                {!! Form::text('phone', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('vendor_web_url', 'Vendor Website') !!}
                                {!! Form::text('vendor_web_url', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('vendor_id', 'Vendor Identity') !!}
                                {!! Form::text('vendor_id', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('status', 'Status') !!}
                                {!! Form::select('status', [''=>'Choose an option'] + Config::get('constants.ACTIVE_VENDOR_STATUSES'), null, ['class'=>'form-control']) !!}
                            </div>

                        </div>

                        <div class="col-md-6">



                            <div class="form-group">
                                {!! Form::label('contact_person_name', 'Contact Person Name') !!}
                                {!! Form::text('contact_person_name', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('contact_person_phone', 'Contact Person Phone') !!}
                                {!! Form::text('contact_person_phone', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('contact_person_secondary_phone', 'Contact Person Secondary Phone') !!}
                                {!! Form::text('contact_person_secondary_phone', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('contact_person_email', 'Contact Person Email') !!}
                                {!! Form::text('contact_person_email', null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('address', 'Address') !!}
                                {!! Form::textarea('address', null, ['class'=>'form-control', 'size' => '30x4']) !!}
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

        $("#status").select2({
            placeholder: "Choose an option"
        });

    });


</script>

@endsection
