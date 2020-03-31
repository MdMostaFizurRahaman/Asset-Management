@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Attach File </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Vendor Enlistment Info</h3>
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
                                    <td>{{ $enlistvendor->id }}</td>
                                    <td>{{ $enlistvendor->vendors->name }}</td>
                                    <td>{{ $enlistvendor->vendors->email }}</td>
                                    <td>{{ $enlistvendor->vendors->phone }}</td>
                                    <td>{{ $enlistvendor->vendors->address }}</td>
                                    <td>{!! Helper::activeStatuslabel($enlistvendor->status) !!}</td>
                                    <td>{{ $enlistvendor->created_at->diffForHumans() }}</td>
                                    <td>{{ $enlistvendor->updated_at->diffForHumans() }}</td>
                                </tr>

                            </table>
                        </div>
                        <!-- /.box-body -->

                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-permission-create'))

                            <div class="box-header with-border">
                                <h3 class="box-title">Asset Permission</h3>
                            </div>

                            {!! Form::model($enlistvendor, ['method'=>'POST', 'action'=>['client\VendorEnlistmentController@assetpermissionstore', $subdomain, $enlistvendor->id]]) !!}
                            <div class="box-body">

                                <div class="col-md-6">

                                    <div class="form-group">
                                        {!! Form::label('asset_permission', 'Permission Type') !!}
                                        {!! Form::select('asset_permission', [''=>'Choose an option'] + Config::get('constants.ASSET_PERMISSION_TYPES'), null, ['class'=>'form-control multiple']) !!}
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
