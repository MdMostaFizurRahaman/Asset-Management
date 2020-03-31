@extends('layouts.admin')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Vendor Permissions </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Vendor Permission List</h3>
                    </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    <!-- /.box-header -->
                    <div class="box-body table-responsive ">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th class="" style="min-width:50px;">ID</th>
                                <th class="" style="min-width:50px;">Name</th>
                                <th class="" style="min-width:50px;">Status</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                                <th style="width: 170px">Actions</th>
                            </tr>

                            @foreach($vendorpermissions as $vendorpermission)
                            <tr>
                                <td>{{ $vendorpermission->id }}</td>
                                <td>{{ $vendorpermission->name }}</td>
                                <td>{!! Helper::activeStatuslabel($vendorpermission->status) !!}</td>
                                <td>{{ $vendorpermission->created_at->diffForHumans() }}</td>
                                <td>{{ $vendorpermission->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendor-permissions-update'))
                                    <a href="{{ route('admin.vendor-permissions.edit', $vendorpermission->id) }}" class="btn btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendor-permissions-delete'))
                                    <a href="#" class="btn btn-default btn-sm" title="Delete"
                                       onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $vendorpermission->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>

                                    {!! Form::open(['method'=>'DELETE', 'action'=>['admin\VendorPermissionController@destroy', $vendorpermission->id], 'id'=>'deleteForm'.$vendorpermission->id]) !!}
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
                            Page {{ $vendorpermissions->currentPage() }}  , showing {{ $vendorpermissions->count() }} records out of {{ $vendorpermissions->total() }} total
                        </ul>
                    </div>

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{$vendorpermissions->links()}}
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
