@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Roles </h1>

        </section>

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Role List</h3>
                        </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    <!-- /.box-header -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">SN.</th>
                                    <th class="" style="min-width:50px;">Name</th>
                                    <th class="" style="min-width:50px;">Description</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>

                                    <th style="width: 170px">Actions</th>
                                </tr>

                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->display_name }}</td>
                                        <td>{{ $role->description }}</td>
                                        <td>{{ $role->created_at->diffForHumans() }}</td>
                                        <td>{{ $role->updated_at->diffForHumans() }}</td>
                                        <td>
                                            @if($role->name <> 'admin')
                                                @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-categories-update'))
                                                    <a href="{{ route('client.client-roles.edit', [$subdomain, $role->id]) }}"
                                                       class="btn btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                @endif
                                                @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-categories-delete'))
                                                    <button class="btn btn-default btn-sm" title="Delete"
                                                            onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $role->id }}').submit(); } event.returnValue = false; return false;" {{ in_array($role->id, $user_assigned_role) ? 'disabled': ''  }}>
                                                        <i
                                                            class="fa fa-trash"></i></button>

                                                    {!! Form::open(['method'=>'DELETE', 'action'=>['client\ClientRoleController@destroy', $subdomain, $role->id], 'id'=>'deleteForm'.$role->id]) !!}
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
                                Page {{ $roles->currentPage() }} , showing {{ $roles->count() }} records out
                                of {{ $roles->total() }} total
                            </ul>
                        </div>

                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                {{$roles->links()}}
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
