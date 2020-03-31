@extends('layouts.client')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Asset Tags </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Asset Tag List</h3>
                    </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    {!! Form::open(['method'=>'GET', 'action'=>['client\AssetTagController@index', $subdomain]]) !!}

                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('title', 'Title') !!}
                                    {!! Form::text('title', request()->title, ['class'=>'form-control']) !!}
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
                                <th class="" style="min-width:50px;">Title</th>
                                <th class="" style="min-width:50px;">Status</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                                <th style="width: 170px">Actions</th>
                            </tr>

                            @foreach($assettags as $assettag)
                            <tr>
                                <td>{{ $assettag->id }}</td>
                                <td>{{ $assettag->title }}</td>
                                <td>{!! Helper::activeStatuslabel($assettag->status) !!}</td>
                                <td>{{ $assettag->created_at->diffForHumans() }}</td>
                                <td>{{ $assettag->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-tags-update'))
                                    <a href="{{ route('client.asset-tags.edit', [$subdomain, $assettag->id]) }}" class="btn btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-tags-delete'))
                                    <a href="#" class="btn btn-default btn-sm" title="Delete"
                                       onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $assettag->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>

                                    {!! Form::open(['method'=>'DELETE', 'action'=>['client\AssetTagController@destroy', $subdomain, $assettag->id], 'id'=>'deleteForm'.$assettag->id]) !!}
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
                            Page {{ $assettags->currentPage() }}  , showing {{ $assettags->count() }} records out of {{ $assettags->total() }} total
                        </ul>
                    </div>

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{$assettags->appends(request()->all())->links()}}
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
