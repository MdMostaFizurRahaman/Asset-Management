@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Permission Asset to Vendor </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Asset Info</h3>
                        </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    <!-- /.box-header -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">ID</th>
                                    <th class="" style="min-width:50px;">Title</th>
                                    <th class="" style="min-width:50px;">Company</th>
                                    <th class="" style="min-width:50px;">Office Location</th>
                                    <th class="" style="min-width:50px;">Store</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                </tr>

                                <tr>
                                    <td>{{ $asset->id }}</td>
                                    <td>{{ $asset->title }}</td>
                                    <td>{{ $asset->company? $asset->company->title : '' }}</td>
                                    <td>{{ $asset->officelocation ? $asset->officelocation->title : '' }}</td>
                                    <td>{{ $asset->store ? $asset->store->title : '' }}</td>
                                    <td>{!! Helper::activeStatuslabel($asset->status) !!}</td>
                                    <td>{{ $asset->created_at->diffForHumans() }}</td>
                                    <td>{{ $asset->updated_at->diffForHumans() }}</td>
                                </tr>

                            </table>
                        </div>
                        <!-- /.box-body -->

                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-permission-create'))

                            <div class="box-header with-border">
                                <h3 class="box-title">Assign Vendor</h3>
                            </div>

                            <div class="box-header ">
                                <h3 class="box-title"><span class="allpermissions">Vendor Lists</span>
                                    <span class="selectrevert">
                                <input type="checkbox" id="selectAll"> Select All
                                <span class="revert">
                                    <input type="checkbox" id="selectRevert"> Select Revert
                                </span>
                            </span>
                                </h3>
                            </div>

                            {!! Form::open(['method'=>'POST', 'action'=>['client\AssetController@vendorpermissionstore', $subdomain, $asset->id]]) !!}
                            <div class="box-body">

                                <div class="col-md-12">

                                    <div class="form-group">
                                        @foreach($vendors as $key => $name)
                                            <div class="col-md-3">
                                                {!! Form::checkbox('vendor_id[]', $key, null, ['class'=>'check','id'=>'vendorId' . $key]) !!}
                                                {!! Form::label('vendorId' . $key, $name, ['class'=>'permissionlabel','style'=>'padding-left:5px;']) !!}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        {!! Form::close() !!}
                    @endif
                    <!-- /.box-body -->
                        <!-- /.box-header -->
                        <div class="box-header with-border">
                            <h3 class="box-title">Permitted Vendor List</h3>
                        </div>
                        <!-- box-body -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">SN.</th>
                                    <th class="" style="min-width:50px;">Name</th>
                                    <th class="" style="min-width:50px;">Expire Date</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                    <th style="width: 170px">Actions</th>
                                </tr>
                                @foreach($permitted_vendors as $vendor)
                                    <tr>
                                        <td>{{ $vendor->id }}</td>
                                        <td>{{ $vendor->vendors->name }}</td>
                                        <td>{{ $vendor->permission_end_date ? Carbon\Carbon::parse($vendor->permission_end_date)->format('Y-m-d') : 'N/A' }}
                                            @if($vendor->permission_end_date !=null)
                                                @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-permission-time-create'))
                                                    <a href="#" class="btn btn-danger btn-sm" title="Unset Time"
                                                       onclick="if (confirm(&quot;Are you sure you want to Unset time ?&quot;)) { document.getElementById('deleteForm{{ $vendor->id }}').submit(); } event.returnValue = false; return false;"><i
                                                            class="fa fa-remove"></i></a>

                                                    {!! Form::open(['method'=>'POST', 'action'=>['client\AssetController@permissiontimeremove', $subdomain, $vendor->id], 'id'=>'deleteForm'.$vendor->id]) !!}
                                                    {!! Form::close() !!}
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{ $vendor->created_at->diffForHumans() }}</td>
                                        <td>{{ $vendor->updated_at->diffForHumans() }}</td>
                                        <td>
                                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-permission-time-create'))
                                                <a href="{{ route('client.assets.vendor.permission.time',[$subdomain,$vendor->id]) }}"
                                                   class="btn btn-default btn-sm" title="Set Time"><i
                                                        class="fa fa-clock-o"></i></a>
                                            @endif
                                            @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-permission-delete'))

                                                <a href="#" class="btn btn-default btn-sm" title="Delete"
                                                   onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $vendor->id }}').submit(); } event.returnValue = false; return false;"><i
                                                        class="fa fa-trash"></i></a>

                                                {!! Form::open(['method'=>'DELETE', 'action'=>['client\AssetController@vendorpermissiondestroy', $subdomain, $vendor->id], 'id'=>'deleteForm'.$vendor->id]) !!}
                                                {!! Form::close() !!}
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
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


            $('#selectAll').on('ifChecked', function (event) {
                $('.check').iCheck('check');
                triggeredByChild = false;
                $('#selectRevert').iCheck('uncheck');
            });

            $('#selectRevert').on('ifChecked', function (event) {
                $('.check').iCheck('toggle');
                triggeredByChild = false;
            });

            $('#selectAll').on('ifUnchecked', function (event) {
                if (!triggeredByChild) {
                    $('.check').iCheck('uncheck');
                }
                triggeredByChild = false;
            });
            // Removed the checked state from "All" if any checkbox is unchecked
            $('.check').on('ifUnchecked', function (event) {
                triggeredByChild = true;
                $('#selectAll').iCheck('uncheck');
            });

            $('.check').on('ifChecked', function (event) {
                if ($('.check').filter(':checked').length == $('.check').length) {
                    $('#selectAll').iCheck('check');
                }
            });

        });

    </script>

@endsection
