@extends('layouts.vendor')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Vendors </h1>

        </section>

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Vendor List</h3>
                        </div>

                        @include('include.flashMessage')
                        @include('include.error')

                        {!! Form::open(['method'=>'GET', 'action'=>['vendor\VendorUserController@index']]) !!}

                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('role', 'Role') !!}
                                        {!! Form::select('role', ['0'=>'All'] + $roles, request()->role, ['class'=>'form-control', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', request()->name, ['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('email', 'Email') !!}
                                        {!! Form::text('email', request()->email, ['class'=>'form-control']) !!}
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
                                    <th class="" style="min-width:50px;">Vendor</th>
                                    <th class="" style="min-width:50px;">User Id</th>
                                    <th class="" style="min-width:50px;">Email</th>
                                    <th class="" style="min-width:50px;">Role</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                    <th style="width: 170px">Actions</th>
                                </tr>

                                @foreach($vendors as $vendor)
                                    <tr>
                                        <td>{{ $vendor->id }}</td>
                                        <td>{{ $vendor->name }}</td>
                                        <td>{{ $vendor->vendorInfo ? $vendor->vendorInfo->name: 'Not Found' }}</td>
                                        <td>{{ $vendor->username }}{{ $vendor->vendorInfo ? '@'.$vendor->vendorInfo->vendor_id: '@' }}</td>
                                        <td>{{ $vendor->email }}</td>
                                        <td>{{ $vendor->role ? $vendor->role->display_name : 'Not Found' }}</td>
                                        <td>{!! Helper::activeStatuslabel($vendor->status) !!}</td>
                                        <td>{{ $vendor->created_at->diffForHumans() }}</td>
                                        <td>{{ $vendor->updated_at->diffForHumans() }}</td>
                                        <td>
                                            @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-users-update'))
                                                <a href="{{ route('vendor.vendors.edit', $vendor->id) }}"
                                                   class="btn btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('vendors.resetPassword', $vendor->id) }}"
                                                   class="btn btn-default btn-sm" title="Change Password"><i class="fa fa-unlock-alt"></i></a>
                                            @endif
                                            @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can('vendor-users-delete'))
                                                <a href="#" class="btn btn-default btn-sm" title="Delete"
                                                   onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $vendor->id }}').submit(); } event.returnValue = false; return false;"><i
                                                        class="fa fa-trash"></i></a>

                                                {!! Form::open(['method'=>'DELETE', 'action'=>['vendor\VendorUserController@destroy', $vendor->id], 'id'=>'deleteForm'.$vendor->id]) !!}
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
                                Page {{ $vendors->currentPage() }} , showing {{ $vendors->count() }} records out
                                of {{ $vendors->total() }} total
                            </ul>
                        </div>

                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                {{$vendors->appends(request()->all())->links()}}
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

            $("#role").select2({
                placeholder: "Choose an option"
            });
        });

    </script>

@endsection
