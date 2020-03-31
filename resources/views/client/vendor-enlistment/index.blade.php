@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Vendor Enlistments</h1>

        </section>

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Vendors Enlistment List</h3>
                        </div>

                        @include('include.flashMessage')
                        @include('include.error')

                        {!! Form::open(['method'=>'GET', 'action'=>['client\VendorEnlistmentController@index', $subdomain]]) !!}

                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('vendor', 'Vendor') !!}
                                        {!! Form::select('vendor', ['0'=>'All'] + $existvendors, Request::input('vendor'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
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
                                    <th class="" style="min-width:50px;">Vendor</th>
                                    <th class="" style="min-width:50px;">Email</th>
                                    <th class="" style="min-width:50px;">Phone</th>
                                    <th class="" style="min-width:50px;">Address</th>
                                    <th class="" style="min-width:50px;">Enlistment Date</th>
                                    <th class="" style="min-width:50px;">Enlistment End Date</th>
                                    <th class="" style="min-width:50px;">Attachment</th>
                                    <th class="" style="min-width:50px;">Asset Permission</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>

                                    <th style="width: 170px">Actions</th>
                                </tr>

                                @foreach($vendors as $vendor)
                                    <tr>
                                        <td>{{ $vendor->id }}</td>
                                        <td>{{ $vendor->vendors->name }}</td>
                                        <td>{{ $vendor->vendors->email }}</td>
                                        <td>{{ $vendor->vendors->phone }}</td>
                                        <td>{{ $vendor->vendors->address }}</td>
                                        <td>{{ $vendor->enlist_date ? Carbon\Carbon::parse($vendor->enlist_date)->format('Y-m-d') : '' }}</td>
                                        <td>{{ $vendor->enlist_end_date? Carbon\Carbon::parse($vendor->enlist_end_date)->format('Y-m-d') : ''}}</td>
                                        <td>{{ $vendor->attachments ? $vendor->attachments->count() : '0' }}</td>
                                        <td>{!! Helper::vendorAssetStatusLabel($vendor->asset_permission) !!}</td>
                                        <td>{!! Helper::activeStatuslabel($vendor->status) !!}</td>
                                        <td>{{ $vendor->created_at->diffForHumans() }}</td>
                                        <td>{{ $vendor->updated_at->diffForHumans() }}</td>
                                        <td>
                                            <a href="{{ route('client.vendor-enlistments.show', [$subdomain, $vendor->id]) }}"
                                               class="btn btn-default btn-sm" title="Detail"><i class="fa fa-eye"></i></a>
                                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-vendor-enlistment-update'))
                                                <a href="{{ route('client.vendor-enlistments.edit', [$subdomain, $vendor->id]) }}"
                                                   class="btn btn-default btn-sm" title="Edit"><i
                                                        class="fa fa-edit"></i></a>

                                                <a href="{{ route('client.vendor-enlistments.attach.file', [$subdomain, $vendor->id]) }}" class="btn btn-default btn-sm" title="Attach File"><i
                                                        class="fa fa-file"></i></a>
                                            @endif
                                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-permission-create'))
                                                <a href="{{ route('client.vendor-enlistments.asset.permission', [$subdomain, $vendor->id]) }}"
                                                   class="btn btn-default btn-sm" title="Permission"><i class="fa fa-check-square-o"></i></a>
                                            @endif
                                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-vendor-enlistment-delete'))
                                                <a href="#" class="btn btn-default btn-sm" title="Delete"
                                                   onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $vendor->id }}').submit(); } event.returnValue = false; return false;"><i
                                                        class="fa fa-trash"></i></a>
                                                {!! Form::open(['method'=>'DELETE', 'action'=>['client\VendorEnlistmentController@destroy', $subdomain, $vendor->id], 'id'=>'deleteForm'.$vendor->id]) !!}
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
                                Page {{ $vendors->currentPage() }} , showing {{ $vendors->count() }} records
                                out of {{ $vendors->total() }} total
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

            $(".multiple").select2({
                placeholder: "Choose an option"
            });

        })
    </script>

@endsection
