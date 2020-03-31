@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Return Asset to Store </h1>

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
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                </tr>

                                <tr>
                                    <td>{{ $asset->id }}</td>
                                    <td>{{ $asset->title }}</td>
                                    <td>{{ $asset->company? $asset->company->title : '' }}</td>
                                    <td>{{ $asset->officelocation ? $asset->officelocation->title : '' }}</td>
                                    <td>{!! Helper::assetAssignStatusLabel($asset->accept_reject_status) !!}</td>
                                    <td>{{ $asset->created_at->diffForHumans() }}</td>
                                    <td>{{ $asset->updated_at->diffForHumans() }}</td>
                                </tr>

                            </table>
                        </div>
                        <!-- /.box-body -->
                        {!! Form::open(['method'=>'POST', 'action'=>['client\ClientController@assetupdate', $subdomain, $asset->id]]) !!}
                        <div class="box-body">

                            <div class="col-md-6">

                                <div class="form-group">
                                    {!! Form::label('return_note', 'Return Note') !!}
                                    {!! Form::textarea('return_note', null, ['class'=>'form-control resize-vertical', 'size' => '30x4']) !!}
                                </div>
                            </div>
                        </div>

                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    {!! Form::close() !!}
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

            $("#assign_user").select2({
                placeholder: "Choose an option"
            });

        });

    </script>

@endsection
