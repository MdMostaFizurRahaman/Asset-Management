@extends('layouts.client')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Assessment Timeline </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- row -->
            <div class="row">
                <div class="col-md-12">

                    <div class="box">

                        <div class="box-header with-border">
                            <h3 class="box-title">Assessment Info</h3>
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
                                    <th class="" style="min-width:50px;">Vendor</th>
                                    <th class="" style="min-width:50px;">Required Days</th>
                                    <th class="" style="min-width:50px;">Submit Date</th>
                                    <th class="" style="min-width:50px;">Cost</th>
                                    <th class="" style="min-width:50px;">Note</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                </tr>

                                <tr>
                                    <td>{{ $assessment->id }}</td>
                                    <td>{{ $assessment->asset->title }}</td>
                                    <td>{{ $assessment->workflow->title }}</td>
                                    <td>{{ $assessment->vendor->name }}</td>
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

                        <div class="box-body">
                            <ul class="timeline">

                                @foreach($assessment->approvals->whereIn('status', [2, 3]) as $approval)
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

                                @if(in_array($assessment->status ,[2,3]))
                                    <li>
                                        <i class="fa fa-stop bg-gray"></i>
                                    </li>
                                @endif
                            <!-- timeline time label -->
                            </ul>
                        </div>
                    </div>

                    <!-- The time line -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection
