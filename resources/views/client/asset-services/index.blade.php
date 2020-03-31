@extends('layouts.client')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Asset Services </h1>

    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Asset Service List</h3>
                    </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    {!! Form::open(['method'=>'GET', 'action'=>['client\AssetServiceController@index', $subdomain]]) !!}

                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('title', 'Title') !!}
                                    {!! Form::text('title', request()->title, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('type', 'Type') !!}
                                    {!! Form::select('type', ['2'=>'All'] + Config::get('constants.ACTIVE_PUBLIC_TYPES'), request()->type, ['class'=>'form-control', 'style'=>'width:100%;']) !!}
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
                                <th class="" style="min-width:50px;">Type</th>
                                <th class="" style="min-width:50px;">Status</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>
                                <th style="width: 170px">Actions</th>
                            </tr>

                            @foreach($assetservices as $assetservice)
                            <tr>
                                <td>{{ $assetservice->id }}</td>
                                <td>{{ $assetservice->title }}</td>
                                <td>{!! Helper::activePublicTypes($assetservice->public) !!}</td>
                                <td>{!! Helper::activeStatuslabel($assetservice->status) !!}</td>
                                <td>{{ $assetservice->created_at->diffForHumans() }}</td>
                                <td>{{ $assetservice->updated_at->diffForHumans() }}</td>
                                <td>
                                    @if($assetservice->public <> 1)
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-services-update'))
                                    <a href="{{ route('client.asset-services.edit', [$subdomain, $assetservice->id]) }}" class="btn btn-default btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                    @endif
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-asset-services-delete'))
                                    <a href="#" class="btn btn-default btn-sm" title="Delete"
                                       onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $assetservice->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-trash"></i></a>

                                    {!! Form::open(['method'=>'DELETE', 'action'=>['client\AssetServiceController@destroy', $subdomain, $assetservice->id], 'id'=>'deleteForm'.$assetservice->id]) !!}
                                    {!! Form::close() !!}
                                    @endif
                                    @endif

                                </td>
                            </tr>
                            @endforeach


                        </table>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            Page {{ $assetservices->currentPage() }}  , showing {{ $assetservices->count() }} records out of {{ $assetservices->total() }} total
                        </ul>
                    </div>

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{$assetservices->appends(request()->all())->links()}}
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

        $("#type").select2({
            placeholder: "Choose an option"
        });
    });

</script>

@endsection
