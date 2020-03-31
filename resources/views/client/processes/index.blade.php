@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Workflow Processes </h1>

        </section>

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <div class="box-header with-border">
                            <h3 class="box-title">Workflow Info</h3>
                        </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    <!-- /.box-header -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">ID</th>
                                    <th class="" style="min-width:50px;">Title</th>
                                    <th class="" style="min-width:50px;">Description</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                </tr>

                                <tr>
                                    <td>{{ $workflow->id }}</td>
                                    <td>{{ $workflow->title }}</td>
                                    <td>{!! $workflow->description !!}</td>
                                    <td>{!! Helper::activeStatuslabel($workflow->status) !!}</td>
                                    <td>{{ $workflow->created_at->diffForHumans() }}</td>
                                    <td>{{ $workflow->updated_at->diffForHumans() }}</td>
                                </tr>

                            </table>
                        </div>

                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-processes-create'))
                            <div class="box-header with-border">
                                <h3 class="box-title">New Process Info</h3>
                            </div>

                            {!! Form::open(['method'=>'POST', 'action'=>['client\ProcessController@store', $subdomain, $workflow->id]]) !!}

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

                                    <div class="form-group minimum_no"
                                         @if(old('type') <> 3) style="display: none; @endif">
                                        {!! Form::label('minimum_no', 'Minimum No Of User') !!}
                                        {!! Form::text('minimum_no', null, ['class'=>'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('process_type', 'Action For Not Complete (Rejected)') !!}
                                        {!! Form::select('process_type', [''=>'Choose an option'] + Config::get('constants.PROCESS_NOT_COMPLETE_TYPES'), null, ['class'=>'form-control']) !!}
                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">
                                        {!! Form::label('order', 'Order') !!}
                                        {!! Form::text('order', null, ['class'=>'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('description', 'Description') !!}
                                        {!! Form::textarea('description', null, ['class'=>'form-control', 'size' => '30x4']) !!}
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
                        @endif

                        <div class="box-header with-border">
                            <h3 class="box-title">Process List</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">SN.</th>
                                    <th class="" style="min-width:50px;">Title</th>
                                    <th class="" style="min-width:50px;">Type</th>
                                    <th class="" style="min-width:50px;">Action For Not Complete(Rejected)</th>
                                    <th class="" style="min-width:50px;">Order</th>
                                    <th class="" style="min-width:50px;">Description</th>
                                    <th class="" style="min-width:50px;">Users</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                    <th style="width: 170px">Actions</th>
                                </tr>

                                @foreach($workflow->processes as $process)
                                    <tr>
                                        <td>{{ $process->id }}</td>
                                        <td>{{ $process->title }}</td>
                                        <td>
                                            {!! Helper::activeProcessTypes($process->type) !!}
                                            @if($process->type == 3)
                                                <br><span
                                                    class="label label-default">Minimum No Of User: {{ $process->minimum_no }}</span>
                                            @endif
                                        </td>
                                        <td>{!! Helper::activeProcessNotCompleteLabel($process->process_type) !!}</td>
                                        <td>{{ $process->order }}</td>
                                        <td>{{ $process->description }}</td>
                                        <td>
                                            @foreach($process->users as $user)
                                                <span class="label label-default">{{ $user->attachuser->name ?? ''}}</span>
                                                <br>
                                            @endforeach
                                        </td>
                                        <td>{!! Helper::activeStatuslabel($process->status) !!}</td>
                                        <td>{{ $process->created_at->diffForHumans() }}</td>
                                        <td>{{ $process->updated_at->diffForHumans() }}</td>
                                        <td>
                                            @if($in_progress_check == 0)
                                                @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-processes-update'))
                                                    <a href="{{ route('client.processes.edit', [$subdomain, $workflow->id, $process->id]) }}"
                                                       class="btn btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                @endif
                                                @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-processusers-read'))
                                                    <a href="{{ route('client.processusers.index', [$subdomain, $process->id]) }}"
                                                       class="btn btn-default btn-sm" title="Assign User"><i class="fa fa-users"></i></a>
                                                @endif
                                                @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-processes-delete'))
                                                    <a href="#" class="btn btn-default btn-sm" title="Delete"
                                                       onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $process->id }}').submit(); } event.returnValue = false; return false;"><i
                                                            class="fa fa-trash"></i></a>
                                                    {!! Form::open(['method'=>'DELETE', 'action'=>['client\ProcessController@destroy', $subdomain, $workflow->id, $process->id], 'id'=>'deleteForm'.$process->id]) !!}
                                                    {!! Form::close() !!}
                                                @endif
                                            @else
                                                <a disabled href="javascript:void(0)" class="btn btn-default btn-sm"><i
                                                        class="fa fa-edit"></i></a>
                                                <a disabled href="javascript:void(0)" class="btn btn-default btn-sm"><i
                                                        class="fa fa-users"></i></a>
                                                <a disabled href="javascript:void(0)" class="btn btn-default btn-sm"><i
                                                        class="fa fa-trash"></i></a>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach


                            </table>
                        </div>
                        <!-- /.box-body -->

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
                if (this.value == 3) {
                    $(".minimum_no").show();
                } else {
                    $(".minimum_no").hide();
                }
            });
        });


    </script>

@endsection
