@extends('layouts.client')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Users </h1>

    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">User List</h3>
                    </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    {!! Form::open(['method'=>'GET', 'action'=>['client\UserController@index', $subdomain]]) !!}

                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('company', 'Company') !!}
                                    {!! Form::select('company', ['0'=>'All'] + $companies, Request::input('company'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('division', 'Division') !!}
                                    {!! Form::select('division', ['0'=>'All'] + $divisions, Request::input('division'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('department', 'Department') !!}
                                    {!! Form::select('department', ['0'=>'All'] + $departments, Request::input('department'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('unit', 'Unit') !!}
                                    {!! Form::select('unit', ['0'=>'All'] + $units, Request::input('unit'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('location', 'Office Location') !!}
                                    {!! Form::select('location', ['0'=>'All'] + $locations, Request::input('location'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('designation', 'Designation') !!}
                                    {!! Form::select('designation', ['0'=>'All'] + $designations, Request::input('designation'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('role', 'Role') !!}
                                    {!! Form::select('role', ['0'=>'All'] + $roles, Request::input('role'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('name', 'Name') !!}
                                    {!! Form::text('name', Request::input('name'), ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('email', 'Email') !!}
                                    {!! Form::text('email', Request::input('email'), ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('phone', 'Phone') !!}
                                    {!! Form::text('phone', Request::input('phone'), ['class'=>'form-control']) !!}
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
                                <th class="" style="min-width:50px;">Name</th>
                                <th class="" style="min-width:50px;">Company</th>
                                <th class="" style="min-width:50px;">Division</th>
                                <th class="" style="min-width:50px;">Department</th>
                                <th class="" style="min-width:50px;">Unit</th>
                                <th class="" style="min-width:50px;">Office Location</th>
                                <th class="" style="min-width:50px;">Designation</th>
                                <th class="" style="min-width:50px;">Role</th>
                                <th class="" style="min-width:50px;">Email</th>
                                <th class="" style="min-width:50px;">Phone</th>
                                <th class="" style="min-width:50px;">Active</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                                <th style="width: 170px">Actions</th>
                            </tr>

                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->company ? $user->company->title : '' }}</td>
                                <td>{{ $user->division ? $user->division->title : '' }}</td>
                                <td>{{ $user->department ? $user->department->title : '' }}</td>
                                <td>{{ $user->unit ? $user->unit->title : '' }}</td>
                                <td>{{ $user->officelocation ? $user->officelocation->title : '' }}</td>
                                <td>{{ $user->designation ? $user->designation->title : '' }}</td>
                                <td>{{ $user->role ? $user->role->display_name : '' }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{!! Helper::activeStatuslabel($user->status) !!}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>{{ $user->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-users-read'))
                                    <a href="{{ route('client.users.show', [$subdomain, $user->id]) }}"
                                       class="btn btn-default btn-sm" title="Detail"><i class="fa fa-eye"></i></a>
                                    @endif
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-users-update'))
                                    <a href="{{ route('client.users.edit', [$subdomain, $user->id]) }}" class="btn btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('client.users.resetPassword', [$subdomain, $user->id]) }}" class="btn btn-default btn-sm" title="Change Password"><i class="fa fa-unlock-alt"></i></a>
                                    @endif
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-users-delete'))
                                    <a href="#" class="btn btn-default btn-sm" title="Delete"
                                       onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $user->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>

                                    {!! Form::open(['method'=>'DELETE', 'action'=>['client\UserController@destroy', $subdomain, $user->id], 'id'=>'deleteForm'.$user->id]) !!}
                                    {!! Form::close() !!}
                                    @endif

                                </td>
                            </tr>
                            @endforeach


                        </table>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            Page {{ $users->currentPage() }}  , showing {{ $users->count() }} records out of {{ $users->total() }} total
                        </ul>
                    </div>

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{$users->appends(request()->all())->links()}}
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
    });

</script>

@endsection
