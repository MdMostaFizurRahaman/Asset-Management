@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Vendor Permission Time </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Vendor Info</h3>
                        </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    <!-- /.box-header -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">ID</th>
                                    <th class="" style="min-width:50px;">Name</th>
                                    <th class="" style="min-width:50px;">Email</th>
                                    <th class="" style="min-width:50px;">Phone</th>
                                    <th class="" style="min-width:50px;">Address</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                </tr>

                                <tr>
                                    <td>{{ $vendor->vendors->id }}</td>
                                    <td>{{ $vendor->vendors->name }}</td>
                                    <td>{{ $vendor->vendors->email }}</td>
                                    <td>{{ $vendor->vendors->phone }}</td>
                                    <td>{{ $vendor->vendors->address }}</td>
                                    <td>{!! Helper::activeVendorInfoStatusLabel($vendor->vendors->status) !!}</td>
                                    <td>{{ $vendor->vendors->created_at->diffForHumans() }}</td>
                                    <td>{{ $vendor->vendors->updated_at->diffForHumans() }}</td>
                                </tr>

                            </table>
                        </div>
                        <!-- /.box-body -->

                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-permission-time-create'))

                            <div class="box-header with-border">
                                <h3 class="box-title">Permission Time</h3>
                            </div>

                            {!! Form::model($vendor,['method'=>'POST', 'action'=>['client\AssetController@vendorpermissiontimestore', $subdomain, $vendor->id]]) !!}
                            <div class="box-body">

                                <div class="col-md-6">

                                    <div class="form-group">
                                        {!! Form::label('permission_end_date', 'Expire Date') !!}
                                        {!! Form::text('permission_end_date', null, ['class'=>'form-control']) !!}
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

            //Datepicker
            $('#permission_end_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd',
                clearBtn: true,
                todayHighlight: true
            });

        });

    </script>

@endsection
