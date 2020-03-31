@extends('layouts.admin')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Client Users </h1>

    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Client User List</h3>
                    </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    {!! Form::open(['method'=>'GET', 'action'=>['admin\ClientUserController@index']]) !!}

                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('client_id', 'Client') !!}
                                    {!! Form::select('client_id', ['0'=>'All'] + $clients, Request::input('client_id'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('role_id', 'Role') !!}
                                    {!! Form::select('role_id', ['0'=>'All'] + $roles, Request::input('role_id'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>


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
                                <th class="" style="min-width:50px;">ID</th>
                                <th class="" style="min-width:50px;">Client</th>
                                <th class="" style="min-width:50px;">Company</th>
                                <th class="" style="min-width:50px;">Division</th>
                                <th class="" style="min-width:50px;">Department</th>
                                <th class="" style="min-width:50px;">Unit</th>
                                <th class="" style="min-width:50px;">Office Location</th>
                                <th class="" style="min-width:50px;">Designation</th>
                                <th class="" style="min-width:50px;">Role</th>
                                <th class="" style="min-width:50px;">Name</th>
                                <th class="" style="min-width:50px;">Email</th>
                                <th class="" style="min-width:50px;">Phone</th>
                                <th class="" style="min-width:50px;">Status</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                                <th style="width: 170px">Actions</th>
                            </tr>

                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->client->name }}</td>
                                <td>{{ $user->company ? $user->company->title : '' }}</td>
                                <td>{{ $user->division ? $user->division->title : '' }}</td>
                                <td>{{ $user->department ? $user->department->title : '' }}</td>
                                <td>{{ $user->unit ? $user->unit->title : '' }}</td>
                                <td>{{ $user->officelocation ? $user->officelocation->title : '' }}</td>
                                <td>{{ $user->designation ? $user->designation->title : '' }}</td>
                                <td>{{ $user->role ? $user->role->display_name : '' }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{!! Helper::activeStatuslabel($user->status) !!}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>{{ $user->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-client-users-update'))
                                    <a href="{{ route('admin.client-users.edit', $user->id) }}" class="btn btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                    <a href="{{ route('admin.client-users.resetPassword', $user->id) }}" class="btn btn-default btn-sm" title="Change Password"><i class="fa fa-unlock-alt"></i></a>
                                    @endif
                                    @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-client-users-delete'))
                                    <a href="#" class="btn btn-default btn-sm" title="Delete"
                                       onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $user->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>

                                    {!! Form::open(['method'=>'DELETE', 'action'=>['admin\ClientUserController@destroy', $user->id], 'id'=>'deleteForm'.$user->id]) !!}
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

        $("#client_id").on("change", function (e) {
            $('#role_id')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Loading</option>');
            $('#role_id').trigger('change');

            if ($('#client_id').val() == '') {
                $('#role_id')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Choose an option</option>');
                $('#role_id').trigger('change');
            }
            else {
                $.ajax({
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", client_id: $('#client_id').val(), role_id: $('#role_id').val(), includeAll: 1, listAll: 1},
                    url: "{{ route('admin.client.roles') }}",
                    success: function (data) {
                        $('#role_id')
                                .find('option')
                                .remove()
                                .end()
                                .append(data);
                        $('#role_id').trigger('change');
                    }
                });
            }
        });

        $("#client_id").on("change", function (e) {
            $('#company')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Loading</option>');
            $('#company').trigger('change');

            if ($('#client_id').val() == '') {
                $('#company')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Choose an option</option>');
                $('#company').trigger('change');
            }
            else {
                $.ajax({
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", client_id: $('#client_id').val(), company: $('#company').val(), includeAll: 1, listAll: 1},
                    url: "{{ route('admin.client.getCompanies') }}",
                    success: function (data) {
                        $('#company')
                                .find('option')
                                .remove()
                                .end()
                                .append(data);
                        $('#company').trigger('change');
                    }
                });
            }
        });

        $("#client_id").on("change", function (e) {
            $('#division')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Loading</option>');
            $('#division').trigger('change');

            if ($('#client_id').val() == '') {
                $('#division')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Choose an option</option>');
                $('#division').trigger('change');
            }
            else {
                $.ajax({
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", client_id: $('#client_id').val(), division: $('#division').val(), includeAll: 1, listAll: 1},
                    url: "{{ route('admin.client.getDivisions') }}",
                    success: function (data) {
                        $('#division')
                                .find('option')
                                .remove()
                                .end()
                                .append(data);
                        $('#division').trigger('change');
                    }
                });
            }
        });

        $("#client_id").on("change", function (e) {
            $('#department')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Loading</option>');
            $('#department').trigger('change');

            if ($('#client_id').val() == '') {
                $('#department')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Choose an option</option>');
                $('#department').trigger('change');
            }
            else {
                $.ajax({
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", client_id: $('#client_id').val(), department: $('#department').val(), includeAll: 1, listAll: 1},
                    url: "{{ route('admin.client.getDepartments') }}",
                    success: function (data) {
                        $('#department')
                                .find('option')
                                .remove()
                                .end()
                                .append(data);
                        $('#department').trigger('change');
                    }
                });
            }
        });

        $("#client_id").on("change", function (e) {
            $('#unit')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Loading</option>');
            $('#unit').trigger('change');

            if ($('#client_id').val() == '') {
                $('#unit')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Choose an option</option>');
                $('#unit').trigger('change');
            }
            else {
                $.ajax({
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", client_id: $('#client_id').val(), unit: $('#unit').val(), includeAll: 1, listAll: 1},
                    url: "{{ route('admin.client.getUnits') }}",
                    success: function (data) {
                        $('#unit')
                                .find('option')
                                .remove()
                                .end()
                                .append(data);
                        $('#unit').trigger('change');
                    }
                });
            }
        });

        $("#client_id").on("change", function (e) {
            $('#location')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Loading</option>');
            $('#location').trigger('change');

            if ($('#client_id').val() == '') {
                $('#location')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Choose an option</option>');
                $('#location').trigger('change');
            }
            else {
                $.ajax({
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", client_id: $('#client_id').val(), location: $('#location').val(), includeAll: 1, listAll: 1},
                    url: "{{ route('admin.client.getLocations') }}",
                    success: function (data) {
                        $('#location')
                                .find('option')
                                .remove()
                                .end()
                                .append(data);
                        $('#location').trigger('change');
                    }
                });
            }
        });

        $("#client_id").on("change", function (e) {
            $('#designation')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Loading</option>');
            $('#designation').trigger('change');

            if ($('#client_id').val() == '') {
                $('#designation')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Choose an option</option>');
                $('#designation').trigger('change');
            }
            else {
                $.ajax({
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", client_id: $('#client_id').val(), designation: $('#designation').val(), includeAll: 1, listAll: 1},
                    url: "{{ route('admin.client.getDesignations') }}",
                    success: function (data) {
                        $('#designation')
                                .find('option')
                                .remove()
                                .end()
                                .append(data);
                        $('#designation').trigger('change');
                    }
                });
            }
        });

    });

</script>

@endsection
