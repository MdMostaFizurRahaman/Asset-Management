@extends('layouts.client')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Process Users </h1>

    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="box">

                    <div class="box-header with-border">
                        <h3 class="box-title">Workflow List</h3>
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
                                <td>{{ $process->workflow->id }}</td>
                                <td>{{ $process->workflow->title }}</td>
                                <td>{!! $process->workflow->description !!}</td>
                                <td>{!! Helper::activeStatuslabel($process->workflow->status) !!}</td>
                                <td>{{ $process->workflow->created_at->diffForHumans() }}</td>
                                <td>{{ $process->workflow->updated_at->diffForHumans() }}</td>
                            </tr>

                        </table>
                    </div>

                    <div class="box-header with-border">
                        <h3 class="box-title">Process Info</h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table-responsive ">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th class="" style="min-width:50px;">ID</th>
                                <th class="" style="min-width:50px;">Title</th>
                                <th class="" style="min-width:50px;">Type</th>
                                <th class="" style="min-width:50px;">Action For Not Complete</th>
                                <th class="" style="min-width:50px;">Description</th>
                                <th class="" style="min-width:50px;">Status</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                            </tr>

                            <tr>
                                <td>{{ $process->id }}</td>
                                <td>{{ $process->title }}</td>
                                <td>
                                    {!! Helper::activeProcessTypes($process->type) !!}
                                    @if($process->type == 3)
                                    <br><span class="label label-default">Minimum No Of User: {{ $process->minimum_no }}</span>
                                    @endif
                                </td>
                                <td>{!! Helper::activeProcessNotCompleteLabel($process->process_type) !!}</td>
                                <td>{{ $process->description }}</td>
                                <td>{!! Helper::activeStatuslabel($process->status) !!}</td>
                                <td>{{ $process->created_at->diffForHumans() }}</td>
                                <td>{{ $process->updated_at->diffForHumans() }}</td>
                            </tr>

                        </table>
                    </div>
                    <!-- /.box-body -->
                    @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-processusers-create'))
                    <div class="box-header with-border">
                        <h3 class="box-title">New Process User Info</h3>
                    </div>

                    {!! Form::open(['method'=>'POST', 'action'=>['client\ProcessUserController@store', $subdomain, $process->id]]) !!}

                    <div class="box-body">
                        <div class="col-md-6">

                            <div class="form-group">
                                {!! Form::label('attachuser_id', 'User') !!}
                                {!! Form::select('attachuser_id', [''=>'Choose an option']+$users, null, ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('description', 'Description') !!}
                                {!! Form::textarea('description', null, ['class'=>'form-control', 'size' => '30x4']) !!}
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
                        <h3 class="box-title">Process User List</h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table-responsive ">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th class="" style="min-width:50px;">SN.</th>
                                <th class="" style="min-width:50px;">User</th>
                                <th class="" style="min-width:50px;">Description</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                            </tr>

                            @foreach($process->users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->attachuser->name }}</td>
                                <td>{!! $user->description !!}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>{{ $user->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-processusers-delete'))
                                    <a href="#" class="btn btn-default btn-sm" title="Delete"
                                       onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $user->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>
                                    {!! Form::open(['method'=>'DELETE', 'action'=>['client\ProcessUserController@destroy', $subdomain, $process->id, $user->id], 'id'=>'deleteForm'.$user->id]) !!}
                                    {!! Form::close() !!}
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

            $("#attachuser_id").select2({
            placeholder: "Choose an option"
            });
            });


</script>

@endsection
