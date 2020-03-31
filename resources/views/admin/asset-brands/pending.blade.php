@extends('layouts.admin')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Asset Pending Brands </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Asset Pending Brand List</h3>
                    </div>

                    @include('include.flashMessage')
                    @include('include.error')
                    
                    {!! Form::open(['method'=>'GET', 'action'=>['admin\AssetBrandController@pending']]) !!}

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
                                <th class="" style="min-width:50px;">ID</th>
                                <th class="" style="min-width:50px;">Title</th>
                                <th class="" style="min-width:50px;">Type</th>
                                <th class="" style="min-width:50px;">Status</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>

                                <th style="width: 170px">Actions</th>
                            </tr>

                            @foreach($assetbrands as $assetbrand)
                            <tr>
                                <td>{{ $assetbrand->id }}</td>
                                <td>{{ $assetbrand->title }}</td>
                                <td>{!! Helper::activePublicTypes($assetbrand->public) !!}</td>
                                <td>{!! Helper::activeStatuslabel($assetbrand->status) !!}</td>
                                <td>{{ $assetbrand->created_at->diffForHumans() }}</td>
                                <td>{{ $assetbrand->updated_at->diffForHumans() }}</td>
                                <td>        
                                    @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-brands-approved'))
                                    <a href="#" class="btn btn-default btn-sm" title="Make Public"
                                       onclick="if (confirm(&quot;Are you sure you want to make public ?&quot;)) { document.getElementById('publicForm{{ $assetbrand->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-check"></i></a>

                                    {!! Form::open(['method'=>'PATCH', 'action'=>['admin\AssetBrandController@approved', $assetbrand->id], 'id'=>'publicForm'.$assetbrand->id]) !!}
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
                            Page {{ $assetbrands->currentPage() }}  , showing {{ $assetbrands->count() }} records out of {{ $assetbrands->total() }} total
                        </ul>
                    </div>

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{$assetbrands->appends(request()->all())->links()}}
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