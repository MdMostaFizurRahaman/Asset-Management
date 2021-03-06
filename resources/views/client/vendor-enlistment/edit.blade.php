@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>New Vendor Enlistment </h1>

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

                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-vendor-enlistment-update'))

                            <div class="box-header with-border">
                                <h3 class="box-title">Enlistment Details</h3>
                            </div>

                            {!! Form::model($enlistvendor, ['method'=>'PATCH', 'action'=>['client\VendorEnlistmentController@update', $subdomain, $enlistvendor->id]]) !!}
                            <div class="box-body">

                                <div class="col-md-6">

                                    <div class="form-group">
                                        {!! Form::label('enlist_date', 'Enlistment Date') !!}
                                        {!! Form::text('enlist_date', null, ['class'=>'form-control', 'autocomplete'=>'off']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('enlist_end_date', 'Enlistment End Date') !!}
                                        {!! Form::text('enlist_end_date', null, ['class'=>'form-control', 'autocomplete'=>'off']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('note', 'Note') !!}
                                        {!! Form::textarea('note', null, ['class'=>'form-control resize-vertical', 'size' => '30x4']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::checkbox('status', '1', null, ['id'=>'status', 'class'=>'form-control']) !!}
                                        {!! Form::label('status', '&nbsp;Active') !!}
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
            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
            //Datepicker
            $('#enlist_date').datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
            });

            $('#enlist_end_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

        });
    </script>

@endsection
