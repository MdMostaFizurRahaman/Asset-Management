@extends('layouts.admin')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Assessments </h1>

    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Assessment List</h3>
                    </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    {!! Form::open(['method'=>'GET', 'action'=>['admin\AssessmentController@index']]) !!}

                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('client', 'Client') !!}
                                    {!! Form::select('client', ['0'=>'All'] + $clients, Request::input('client'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('workflow', 'Workflow') !!}
                                    {!! Form::select('workflow', ['0'=>'All'] + $workflows, Request::input('workflow'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('asset', 'Asset') !!}
                                    {!! Form::select('asset', ['0'=>'All'] + $assets, Request::input('asset'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('vendor', 'Vendor') !!}
                                    {!! Form::select('vendor', ['0'=>'All'] + $vendors, Request::input('vendor'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('submit_from', 'Submit Date From') !!}
                                    {!! Form::text('submit_from', Request::input('submit_from'), ['class'=>'form-control date', 'autocomplete'=>'off']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('submit_to', 'Submit Date To') !!}
                                    {!! Form::text('submit_to', Request::input('submit_to'), ['class'=>'form-control date', 'autocomplete'=>'off']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('cost', 'Cost') !!}
                                    {!! Form::text('cost', Request::input('cost'), ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('status', 'Status') !!}
                                    {!! Form::select('status', ['4'=>'All'] + Config::get('constants.ACTIVE_ASSESSMENT_STATUSES'), Request::input('status'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>

                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>

                    {!! Form::close() !!}


                    <!-- /.box-header -->
                    <div class="box-body table-responsive ">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th class="" style="min-width:50px;">ID</th>
                                <th class="" style="min-width:50px;">Asset</th>
                                <th class="" style="min-width:50px;">Client</th>
                                <th class="" style="min-width:50px;">Workflow</th>
                                <th class="" style="min-width:50px;">Vendor</th>
                                <th class="" style="min-width:50px;">Required Days</th>
                                <th class="" style="min-width:50px;">Submit Date</th>
                                <th class="" style="min-width:50px;">Cost</th>
                                <th class="" style="min-width:50px;">Note</th>
                                <th class="" style="min-width:50px;">Status</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                                <th style="width: 170px">Actions</th>
                            </tr>

                            @foreach($assessments as $assessment)
                            <tr>
                                <td>{{ $assessment->id }}</td>
                                <td>{{ $assessment->asset->title }}</td>
                                <td>{{ $assessment->asset->client ? $assessment->asset->client->name : '' }}</td>
                                <td>{{ $assessment->workflow->title }}</td>
                                <td>{{ $assessment->vendor ? $assessment->vendor->name : '' }}</td>
                                <td>{{ $assessment->required_days }}</td>
                                <td>{{ $assessment->submit_date }}</td>
                                <td>{{ $assessment->cost }}</td>
                                <td>{{ $assessment->note }}</td>
                                <td>{!! Helper::activeAssessmentStatuslabel($assessment->status) !!}</td>
                                <td>{{ $assessment->created_at->diffForHumans() }}</td>
                                <td>{{ $assessment->updated_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('admin.assessments.timeline', $assessment->id) }}" class="btn btn-default btn-sm" title="Timeline"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach


                        </table>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            Page {{ $assessments->currentPage() }}  , showing {{ $assessments->count() }} records out of {{ $assessments->total() }} total
                        </ul>
                    </div>

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{$assessments->appends(Request::all())->links()}}
                        </ul>
                    </div>

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

        $(".multiple").select2({
            placeholder: "Choose an option"
        });

        $('.date').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        });

        $("#client").on("change", function (e) {
            $('#workflow')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">loading, please wait</option>');
            $('#workflow').trigger('change');

            $.ajax({
                type: "POST",
                data: { "_token": "{{ csrf_token() }}", client: $('#client').val(), includeAll: 1},
                url: "{{ route('admin.getWorkflows') }}",
                success: function (data) {
                    $('#workflow')
                            .find('option')
                            .remove()
                            .end()
                            .append(data);
                    $('#workflow').trigger('change');
                }
            });
        });

        $("#workflow").on("change", function (e) {
            $('#asset')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">loading, please wait</option>');
            $('#asset').trigger('change');

            $.ajax({
                type: "POST",
                data: { "_token": "{{ csrf_token() }}", client: $('#client').val(), workflow: $('#workflow').val(), includeAll: 1},
                url: "{{ route('admin.workflow.getAssets') }}",
                success: function (data) {
                    $('#asset')
                            .find('option')
                            .remove()
                            .end()
                            .append(data);
                    $('#asset').trigger('change');
                }
            });
        });

    });


</script>

@endsection
