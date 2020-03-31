@extends('layouts.admin')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Asset Pending SubCategories </h1>

    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Asset Pending SubCategory List</h3>
                    </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    {!! Form::open(['method'=>'GET', 'action'=>['admin\AssetSubCategoryController@pending']]) !!}

                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    {!! Form::label('category', 'Category') !!}
                                    {!! Form::select('category', ['0'=>'All'] + $categories, request()->category, ['class'=>'form-control', 'style'=>'width:100%;']) !!}
                                </div>
                            </div>

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
                                <th class="" style="min-width:50px;">Category</th>
                                <th class="" style="min-width:50px;">Title</th>
                                <th class="" style="min-width:50px;">Type</th>
                                <th class="" style="min-width:50px;">Status</th>
                                <th class="" style="min-width:50px;">Created At</th>
                                <th class="" style="min-width:50px;">Updated At</th>

                                <th style="width: 170px">Actions</th>
                            </tr>

                            @foreach($assetsubcategories as $assetsubcategory)
                            <tr>
                                <td>{{ $assetsubcategory->id }}</td>
                                <td>{{ $assetsubcategory->category->title }}</td>
                                <td>{{ $assetsubcategory->title }}</td>
                                <td>{!! Helper::activePublicTypes($assetsubcategory->public) !!}</td>
                                <td>{!! Helper::activeStatuslabel($assetsubcategory->status) !!}</td>
                                <td>{{ $assetsubcategory->created_at->diffForHumans() }}</td>
                                <td>{{ $assetsubcategory->updated_at->diffForHumans() }}</td>
                                <td>  
                                    @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can('admin-asset-subcategories-approved'))
                                    <a href="#" class="btn btn-default btn-sm" title="Make Public"
                                       onclick="if (confirm(&quot;Are you sure you want to make public ?&quot;)) { document.getElementById('publicForm{{ $assetsubcategory->id }}').submit(); } event.returnValue = false; return false;"><i
                                            class="fa fa-check"></i></a>

                                    {!! Form::open(['method'=>'PATCH', 'action'=>['admin\AssetSubCategoryController@approved', $assetsubcategory->id], 'id'=>'publicForm'.$assetsubcategory->id]) !!}
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
                            Page {{ $assetsubcategories->currentPage() }}  , showing {{ $assetsubcategories->count() }} records out of {{ $assetsubcategories->total() }} total
                        </ul>
                    </div>

                    <div class="box-footer clearfix">
                        <ul class="pagination pagination-sm no-margin pull-right">
                            {{$assetsubcategories->appends(request()->all())->links()}}
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

        $("#category").select2({
            placeholder: "Choose an option"
        });
        
    });

</script>

@endsection