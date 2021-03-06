@extends('layouts.client')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Pending For Approvals </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pending For Approval List</h3>
                    </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    {!! Form::open(['method'=>'GET', 'action'=>['client\AssessmentController@pendinglist', $subdomain]]) !!}

                    <div class="box-body">
                        <div class="row">

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
                                    {!! Form::label('type', 'Type') !!}
                                    {!! Form::select('type', ['2'=>'All'] + Config::get('constants.ACTIVE_ASSESSMENT_TYPES'), Request::input('type'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
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
                                <th class="" style="min-width:50px;">SN.</th>
                                <th class="" style="min-width:50px;">Workflow</th>
                                <th class="" style="min-width:50px;">Asset</th>
                                <th class="" style="min-width:50px;">Process</th>
                                <th class="" style="min-width:50px;">Vendor</th>
                                <th class="" style="min-width:50px;">Required Days</th>
                                <th class="" style="min-width:50px;">Submit Date</th>
                                <th class="" style="min-width:50px;">Cost</th>
                                <th class="" style="min-width:50px;">Note</th>
                                <th class="" style="min-width:50px;">Type</th>
                                <th class="" style="min-width:50px;">Status</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                                <th style="width: 170px">Actions</th>
                            </tr>

                            @foreach($assessments as $assessment)
                            <tr>
                                <td>{{ $assessment->id }}</td>
                                <td>{{ $assessment->assessment->workflow->title }}</td>
                                <td>{{ $assessment->assessment->asset->title }}</td>
                                <td>{{ $assessment->assessment->currentstep->title }}</td>
                                <td>{{ $assessment->assessment->vendor->name }}</td>
                                <td>{{ $assessment->assessment->required_days }}</td>
                                <td>{{ $assessment->assessment->submit_date }}</td>
                                <td>{{ $assessment->assessment->cost }}</td>
                                <td>{{ $assessment->assessment->note }}</td>
                                <td>{!! Helper::activeAssessmentTypes($assessment->type) !!}</td>
                                <td>{!! Helper::activeStatuslabel($assessment->status) !!}</td>
                                <td>{{ $assessment->created_at->diffForHumans() }}</td>
                                <td>{{ $assessment->updated_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('client.assessments.approvalreject', [$subdomain, $assessment->id]) }}" class="btn btn-default btn-sm" title="Timeline"><i class="fa fa-eye"></i></a>
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

        $("#workflow").on("change", function (e) {
            $('#asset')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">loading, please wait</option>');
            $('#asset').trigger('change');

            $.ajax({
                type: "POST",
                data: { "_token": "{{ csrf_token() }}", workflow: $('#workflow').val(), includeAll: 1},
                url: "{{ route('client.workflow.getAssets', $subdomain) }}",
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
