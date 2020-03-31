@extends('layouts.admin')
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
                            <h3 class="box-title">Vendors List</h3>
                        </div>

                        @include('include.flashMessage')
                        @include('include.error')

                        {!! Form::open(['method'=>'GET', 'action'=>['admin\VendorInfoController@index']]) !!}

                        <div class="box-body">
                            <div class="row">

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

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('phone', 'Phone') !!}
                                        {!! Form::text('phone', request()->phone, ['class'=>'form-control']) !!}
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
                                    <th class="" style="min-width:50px;">Name</th>
                                    <th class="" style="min-width:50px;">Email</th>
                                    <th class="" style="min-width:50px;">Vendor Identity</th>
                                    <th class="" style="min-width:50px;">Phone</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                    <th style="width: 170px">Actions</th>
                                </tr>

                                @foreach($vendor_infos as $vendor_info)
                                    <tr>
                                        <td>{{ $vendor_info->id }}</td>
                                        <td>{{ $vendor_info->name }}</td>
                                        <td>{{ $vendor_info->email }}</td>
                                        <td><a target="_blank" href="http://{{ 'vendor.' . env('APP_DOMAIN_URL') }}">{{ $vendor_info->vendor_id }}</a></td>
                                        <td>{{ $vendor_info->phone }}</td>
                                        <td>{!! Helper::activeVendorInfoStatusLabel($vendor_info->status) !!}</td>
                                        <td>{{ $vendor_info->created_at->diffForHumans() }}</td>
                                        <td>{{ $vendor_info->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('admin.vendors.show', $vendor_info->id) }}"
                                               class="btn btn-default btn-sm" title="Detail"><i class="fa fa-eye"></i></a>
                                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendor-infos-update'))
                                                <a href="{{ route('admin.vendors.edit', $vendor_info->id) }}"
                                                   class="btn btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                            @endif
                                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendor-roles-read'))
                                                <a href="{{ route('admin.vendor-roles.index', $vendor_info->id) }}"
                                                   class="btn btn-default btn-sm" title="Role"><i class="fa fa-tasks"></i></a>
                                            @endif
                                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-vendor-infos-delete'))
                                                <a href="#" class="btn btn-default btn-sm" title="Delete"
                                                   onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $vendor_info->id }}').submit(); } event.returnValue = false; return false;"><i
                                                        class="fa fa-trash"></i></a>

                                                {!! Form::open(['method'=>'DELETE', 'action'=>['admin\VendorInfoController@destroy', $vendor_info->id], 'id'=>'deleteForm'.$vendor_info->id]) !!}
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
                                Page {{ $vendor_infos->currentPage() }} , showing {{ $vendor_infos->count() }} records
                                out of {{ $vendor_infos->total() }} total
                            </ul>
                        </div>

                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                {{$vendor_infos->appends(request()->all())->links()}}
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
