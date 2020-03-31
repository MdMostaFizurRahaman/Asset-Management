@extends('layouts.admin')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Admin Permissions </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Admin Permission List</h3>
                        </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    <!-- /.box-header -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">ID</th>
                                    <th class="" style="min-width:50px;">Name</th>
                                    <th class="" style="min-width:50px;">Active</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                    <th style="width: 170px">Actions</th>
                                </tr>

                                @foreach($adminpermissions as $adminpermission)
                                    <tr>
                                        <td>{{ $adminpermission->id }}</td>
                                        <td>{{ $adminpermission->name }}</td>
                                        <td>{!! Helper::activeStatuslabel($adminpermission->status) !!}</td>
                                        <td>{{ $adminpermission->created_at->diffForHumans() }}</td>
                                        <td>{{ $adminpermission->updated_at->diffForHumans() }}</td>
                                        <td>
                                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-permissions-update'))
                                                @if(in_array($adminpermission->id, $permission_category_ids))
                                                    <button class="btn btn-default btn-sm" disabled title="Edit"><i class="fa fa-edit"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('admin.admin-permissions.edit', $adminpermission->id) }}"
                                                       class="btn btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                @endif
                                            @endif
                                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-permissions-delete'))
                                                <button class="btn btn-default btn-sm" title="Delete"
                                                        onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $adminpermission->id }}').submit(); } event.returnValue = false; return false;" {{ in_array($adminpermission->id, $permission_category_ids) ? 'disabled': '' }}>
                                                    <i
                                                        class="fa fa-trash"></i></button>

                                                {!! Form::open(['method'=>'DELETE', 'action'=>['admin\AdminPermissionController@destroy', $adminpermission->id], 'id'=>'deleteForm'.$adminpermission->id]) !!}
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
                                Page {{ $adminpermissions->currentPage() }} , showing {{ $adminpermissions->count() }}
                                records out of {{ $adminpermissions->total() }} total
                            </ul>
                        </div>

                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                {{$adminpermissions->links()}}
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
