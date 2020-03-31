@extends('layouts.vendor')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Clients </h1>

    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Client List</h3>
                    </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    <!-- /.box-header -->
                    <div class="box-body table-responsive ">
                        <table class="table table-bordered table-hover">
                            <tr>
                                <th class="" style="min-width:50px;">ID.</th>
                                <th class="" style="min-width:50px;">Name</th>
                                <th class="" style="min-width:50px;">Email</th>
                                <th class="" style="min-width:50px;">Phone</th>
                                <th class="" style="min-width:50px;">Status</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                                <th style="width: 170px">Actions</th>
                            </tr>

                            @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->id }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{!! Helper::activeClientStatuslabel($client->status) !!}</td>
                                <td>{{ $client->created_at->diffForHumans() }}</td>
                                <td>{{ $client->updated_at->diffForHumans() }}</td>
                                <td>
                                    <a href="{{ route('vendor.clients.show', $client->id) }}" class="btn btn-default btn-sm" title="Detail"><i class="fa fa-eye"></i></a>
                                    @if(Auth::guard('vendor')->user()->hasRole('admin') || Auth::guard('vendor')->user()->can(['vendor-assessments-read']))
                                    <a href="{{ route('vendor.assessments.index', $client->id) }}" class="btn btn-default btn-sm" title="Assessment"><i class="fa fa-square"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach


                        </table>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            Page {{ $clients->currentPage() }}  , showing {{ $clients->count() }} records out of {{ $clients->total() }} total
                        </ul>
                    </div>

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{$clients->links()}}
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
