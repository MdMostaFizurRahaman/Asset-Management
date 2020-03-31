@extends('layouts.vendor')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Assessment Services, Accessories </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Client Info</h3>
                        </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    <!-- /.box-header -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">ID</th>
                                    <th class="" style="min-width:50px;">Name</th>
                                    <th class="" style="min-width:50px;">Email</th>
                                    <th class="" style="min-width:50px;">Phone</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                </tr>

                                <tr>
                                    <td>{{ $client->id }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>{!! Helper::activeClientStatuslabel($client->status) !!}</td>
                                    <td>{{ $client->created_at->diffForHumans() }}</td>
                                    <td>{{ $client->updated_at->diffForHumans() }}</td>
                                </tr>

                            </table>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-header with-border">
                            <h3 class="box-title">Assessment Info</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">ID</th>
                                    <th class="" style="min-width:50px;">Asset</th>
                                    <th class="" style="min-width:50px;">Workflow</th>
                                    <th class="" style="min-width:50px;">Total Steps</th>
                                    <th class="" style="min-width:50px;">Current Steps</th>
                                    <th class="" style="min-width:50px;">Required Days</th>
                                    <th class="" style="min-width:50px;">Submit Date</th>
                                    <th class="" style="min-width:50px;">Cost</th>
                                    <th class="" style="min-width:50px;">Note</th>
                                    <th class="" style="min-width:50px;">Active</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                </tr>

                                <tr>
                                    <td>{{ $assessment->id }}</td>
                                    <td>{{ $assessment->asset->title }}</td>
                                    <td>{{ $assessment->workflow->title }}</td>
                                    <td>{{ $assessment->total_steps }}</td>
                                    <td>{{ $assessment->currentstep->title }}</td>
                                    <td>{{ $assessment->required_days }}</td>
                                    <td>{{ $assessment->submit_date }}</td>
                                    <td>{{ $assessment->cost }}</td>
                                    <td>{{ $assessment->note }}</td>
                                    <td>{!! Helper::activeAssessmentStatuslabel($assessment->status) !!}</td>
                                    <td>{{ $assessment->created_at->diffForHumans() }}</td>
                                    <td>{{ $assessment->updated_at->diffForHumans() }}</td>
                                </tr>

                            </table>
                        </div>
                        <!-- /.box-body -->


                        <!-- /.box-body -->

                        <div class="box-header with-border">
                            <h3 class="box-title">Add Services, Accessories</h3>
                        </div>

                        {!! Form::model($assessment, ['method'=>'PATCH', 'action'=>['vendor\AssessmentController@servicestore', $client->id, $assessment->id]]) !!}

                        <div class="box-header">
                            <h3 class="box-title"><span class="allpermissions">Services</span>
                                <span class="selectrevert">
                                    <input type="checkbox" id="serviceAll"> Select All
                                </span>
                                <span class="revert">
                                    <input type="checkbox" id="serviceRevert"> Select Revert
                                </span>
                            </h3>
                        </div>

                        <div class="box-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    @foreach($assessment->asset->services as $service)
                                        <div class="col-md-3">
                                            {!! Form::checkbox('services[]', $service->id, null, ['class'=>'check', 'id'=>'serviceId' . $service->id, in_array($service->id, $assessment->services->pluck('service_id')->all())  ?  'checked' : '']) !!}
                                            {!! Form::label('serviceId' . $service->id, $service->title, ['style'=>'padding-left:5px;']) !!}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="box-header">
                            <h3 class="box-title"><span class="allpermissions">Accessories</span>
                                <span class="selectrevert">
                                    <input type="checkbox" id="hardwareAll"> Select All
                                </span>
                                <span class="revert">
                                    <input type="checkbox" id="hardwareRevert"> Select Revert
                                </span>
                            </h3>
                        </div>

                        <div class="box-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    @foreach($assessment->asset->hardwares as $hardware)
                                        <div class="col-md-3">
                                            {!! Form::checkbox('hardwares[]', $hardware->id, null, ['class'=>'hardwarecheck', 'id'=>'hardwareId' . $hardware->id, in_array($hardware->id, $assessment->accessories->pluck('accessory_id')->all())  ?  'checked' : '']) !!}
                                            {!! Form::label('hardwareId' . $hardware->id, $hardware->title, ['style'=>'padding-left:5px;']) !!}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary preloader">Submit</button>
                        </div>
                        {!! Form::close() !!}

                    </div>
                    <!-- /.box -->

                    <!-- /.box -->
                </div>
                <!-- /.col -->

                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>

@endsection

@section('scripts')

    <script>

        $(function () {
            //loader
            $('.preloader').click(function () {
                $('.loader').addClass('active-loader')
            });

            var triggeredByChild = false;
            var triggeredHardwareChild = false;

            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });


            $('#serviceAll').on('ifChecked', function (event) {
                $('.check').iCheck('check');
                triggeredByChild = false;
                $('#serviceRevert').iCheck('uncheck');
            });

            $('#serviceAll').on('ifUnchecked', function (event) {
                if (!triggeredByChild) {
                    $('.check').iCheck('uncheck');
                }
                triggeredByChild = false;
            });
            // Removed the checked state from "All" if any checkbox is unchecked
            $('.check').on('ifUnchecked', function (event) {
                triggeredByChild = true;
                $('#serviceAll').iCheck('uncheck');
            });

            $('.check').on('ifChecked', function (event) {
                if ($('.check').filter(':checked').length == $('.check').length) {
                    $('#serviceAll').iCheck('check');
                }
            });

            $('#serviceRevert').on('ifChecked', function (event) {
                $('.check').iCheck('toggle');
                triggeredByChild = false;
            });


            $('#hardwareAll').on('ifChecked', function (event) {
                $('.hardwarecheck').iCheck('check');
                triggeredHardwareChild = false;
                $('#hardwareRevert').iCheck('uncheck');
            });

            $('#hardwareAll').on('ifUnchecked', function (event) {
                if (!triggeredHardwareChild) {
                    $('.hardwarecheck').iCheck('uncheck');
                }
                triggeredHardwareChild = false;
            });
            // Removed the checked state from "All" if any checkbox is unchecked
            $('.hardwarecheck').on('ifUnchecked', function (event) {
                triggeredHardwareChild = true;
                $('#hardwareAll').iCheck('uncheck');
            });

            $('.hardwarecheck').on('ifChecked', function (event) {
                if ($('.hardwarecheck').filter(':checked').length == $('.hardwarecheck').length) {
                    $('#hardwareAll').iCheck('check');
                }
            });

            $('#hardwareRevert').on('ifChecked', function (event) {
                $('.hardwarecheck').iCheck('toggle');
                triggeredHardwareChild = false;
            });

        });

    </script>

@endsection
