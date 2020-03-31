@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Assign Asset to User </h1>

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

                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-assets-update'))

                            <div class="box-header with-border">
                                <h3 class="box-title">Assign User</h3>
                            </div>

                            {!! Form::open(['method'=>'POST', 'action'=>['client\AssetController@assignuserstore', $subdomain, $asset->id]]) !!}
                            <div class="box-body">

                                <div class="col-md-6">

                                    <div class="form-group">
                                        {!! Form::label('assign_user', 'Users') !!}
                                        {!! Form::select('assign_user', [''=>'Choose an option']+$users, null, ['class'=>'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('assign_note', 'Assign Note') !!}
                                        {!! Form::textarea('assign_note', null, ['class'=>'form-control resize-vertical', 'size' => '30x4']) !!}
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

            $("#assign_user").select2({
                placeholder: "Choose an option"
            });

        });

    </script>

@endsection
