@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Approval or Reject Assessment </h1>

        </section>

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"> Assessment Info</h3>
                        </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    <!-- /.box-header -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">ID</th>
                                    <th class="" style="min-width:50px;">Asset</th>
                                    <th class="" style="min-width:50px;">Workflow</th>
                                    <th class="" style="min-width:50px;">Process</th>
                                    <th class="" style="min-width:50px;">Vendor</th>
                                    <th class="" style="min-width:50px;">Required Days</th>
                                    <th class="" style="min-width:50px;">Submit Date</th>
                                    <th class="" style="min-width:50px;">Cost</th>
                                    <th class="" style="min-width:50px;">Note</th>
                                    <th class="" style="min-width:50px;">Type</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Accessories</th>
                                    <th class="" style="min-width:50px;">Services</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                </tr>

                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->assessment->asset->title }}</td>
                                    <td>{{ $data->assessment->workflow->title }}</td>
                                    <td>{{ $data->assessment->currentstep->title }}</td>
                                    <td>{{ $data->assessment->vendor->name }}</td>
                                    <td>{{ $data->assessment->required_days }}</td>
                                    <td>{{ $data->assessment->submit_date }}</td>
                                    <td>{{ $data->assessment->cost }}</td>
                                    <td>{{ $data->assessment->note }}</td>
                                    <td>{!! Helper::activeAssessmentTypes($data->type) !!}</td>
                                    <td>{!! Helper::activeAssessmentStatuslabel($data->status) !!}</td>
                                    <td>
                                        @foreach($instrument['assessmentaccessories'] as $accessory)
                                            {!! Helper::accessories($accessory) !!}
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach($instrument['assessmentservices'] as $service)
                                            {!! Helper::services($service) !!}
                                        @endforeach
                                    </td>
                                    <td>{{ $data->created_at->diffForHumans() }}</td>
                                    <td>{{ $data->updated_at->diffForHumans() }}</td>
                                </tr>

                            </table>
                        </div>

                        {{-- timeline--}}
                        <div class="box-header with-border">
                            <h3 class="box-title">Assessment Timeline</h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <ul class="timeline">

                                @foreach($data->assessment->approvals->whereIn('status', [2, 3]) as $approval)
                                    <li class="time-label">
                                <span class="{{ $approval->status == 3 ? 'bg-red' : 'bg-green' }}">
                                    {{ $approval->created_at->format('d M Y') }}
                                </span>
                                        <div class="timeline-item timeline-bg">
                                            <h3 class="timeline-header"><a href="javascript:void(0)">Action Required</a>
                                                {!! Helper::activeProcessTypes($approval->process->type) !!}
                                                @if($approval->process->type == 3)
                                                    <span
                                                        class="label label-danger">Minimum No Of User: {{ $approval->process->minimum_no }}</span>
                                                @endif
                                            </h3>
                                            <div class="timeline-body">
                                                <strong class="custom-style text-purple">User Responsible for Approval
                                                </strong>
                                                @foreach($approval->approvaluserarchive as $userarchive)
                                                    <span class="btn btn-xs btn-primary">
                                                    {{ $userarchive->user->name }}
                                                </span>
                                                @endforeach
                                            </div>

                                            <div class="timeline-footer">
                                                <strong class="text-maroon">Action For Not Complete(Rejected) </strong>
                                                <span>{!! Helper::activeProcessNotCompleteLabel($approval->process->process_type) !!}</span>
                                            </div>
                                        </div>
                                    </li>
                                    @foreach($approval->approvalusers as $user)
                                    <!-- timeline item -->
                                        <li>
                                            <i class="fa fa-user {{ $user->status == 2 ? 'bg-red' : 'bg-aqua' }}"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fa fa-clock-o"></i> {{ $user->created_at->diffForHumans() }}</span>

                                                <h3 class="timeline-header no-border">
                                                    <a href="javascript:void(0)">{{ $user->user->name }}</a>
                                                    <span
                                                        class="btn btn-xs {{ $user->status == 2 ? 'btn-danger' : 'btn-success' }}">
                                                        {!! Helper::activeAssessmentApproval($user->status) !!}
                                                    </span>
                                                </h3>

                                                <div class="timeline-body">
                                                    {!! $user->note !!}
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                <!-- END timeline item -->
                                @endforeach
                                <!-- timeline time label -->
                            </ul>
                        </div>
                        {{-- end timeline--}}
                        @if($checkSubmit == null)
                            <div class="box-header with-border">
                                <h3 class="box-title">Approval or Rejected Note</h3>
                            </div>
                            <!-- /.box-header -->

                            {!! Form::open(['method'=>'PATCH', 'action'=>['client\AssessmentController@approvalrejectstore', $subdomain, $data->id]]) !!}

                            <div class="box-body">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        {!! Form::label('note', 'Note') !!}
                                        {!! Form::textarea('note', null, ['class'=>'form-control resize-vertical', 'size' => '30x4']) !!}
                                    </div>

                                </div>

                            </div>

                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" name="submit" value="approved" class="btn btn-primary preloader"
                                        onclick="if (confirm('Are you sure you want to Approve ?')){ loaderAddClass().submit();} event.returnValue = false; return false;">
                                    Approved
                                </button>
                                <button type="submit" name="submit" value="rejected" class="btn btn-danger preloader"
                                        onclick="if (confirm('Are you sure you want to Reject ?')){ loaderAddClass().submit();} event.returnValue = false; return false;">
                                    Rejected
                                </button>
                            </div>
                            {!! Form::close() !!}
                        <!-- /.box-body -->
                        @endif
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

        function loaderAddClass(){
            $('.loader').addClass('active-loader');
        }

    </script>

@endsection
