@extends('layouts.vendor')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Client Assessments </h1>

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

                        @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-assessments-create'))

                            <div class="box-header with-border">
                                <h3 class="box-title">New Assessment</h3>
                            </div>

                            {!! Form::open(['method'=>'POST', 'action'=>['vendor\AssessmentController@store', $client->id]]) !!}

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

{{--                                    <div class="form-group">--}}
{{--                                        {!! Form::checkbox('status', '1', 1, ['id'=>'status', 'class'=>'form-control']) !!}--}}
{{--                                        {!! Form::label('status', '&nbsp;Active') !!}--}}
{{--                                    </div>--}}

                                </div>
                            </div>

                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            {!! Form::close() !!}
                        @endif

                        <div class="box-header with-border">
                            <h3 class="box-title">Client Assessment List</h3>
                        </div>

                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">ID.</th>
                                    <th class="" style="min-width:50px;">Asset</th>
                                    <th class="" style="min-width:50px;">Workflow</th>
                                    <th class="" style="min-width:50px;">Total Steps</th>
                                    <th class="" style="min-width:50px;">Current Steps</th>
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
                                        <td>
                                            @if($assessment->status == 0)
                                                @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-assessments-create'))
                                                    <a href="{{ route('vendor.assessments.services', [$client->id, $assessment->id]) }}"
                                                       class="btn btn-default btn-sm" title="Services"><i class="fa fa-wrench"></i></a>
                                                @endif
                                                @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-assessments-delete'))
                                                    <a href="#" class="btn btn-default btn-sm" title="Delete"
                                                       onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $assessment->id }}').submit(); } event.returnValue = false; return false;"><i
                                                            class="fa fa-trash"></i></a>

                                                    {!! Form::open(['method'=>'DELETE', 'action'=>['vendor\AssessmentController@destroy', $client->id, $assessment->id], 'id'=>'deleteForm'.$assessment->id]) !!}
                                                    {!! Form::close() !!}
                                                @endif
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                Page {{ $assessments->currentPage() }} , showing {{ $assessments->count() }} records out
                                of {{ $assessments->total() }} total
                            </ul>
                        </div>

                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                {{$assessments->links()}}
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
