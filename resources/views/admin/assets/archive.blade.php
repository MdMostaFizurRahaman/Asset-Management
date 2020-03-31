@extends('layouts.admin')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Assets </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Asset Archive List</h3>
                        </div>

                        @include('include.flashMessage')
                        @include('include.error')

                        {!! Form::open(['method'=>'GET', 'action'=>['admin\AssetController@archive']]) !!}

                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('title', 'Title') !!}
                                        {!! Form::text('title', Request::input('title'), ['class'=>'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('workflow', 'Workflow') !!}
                                        {!! Form::select('workflow', ['0'=>'All'] + $workflows, Request::input('workflow'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('category_id', 'Category') !!}
                                        {!! Form::select('category_id', ['0'=>'All'] + $categories, Request::input('category_id'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('sub_category_id', 'Subcategory') !!}
                                        {!! Form::select('sub_category_id', ['0'=>'All'] + $subcategories, Request::input('sub_category_id'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('brand', 'Brand') !!}
                                        {!! Form::select('brand', ['0'=>'All'] + $brands, Request::input('brand'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('model', 'Model') !!}
                                        {!! Form::text('model', Request::input('model'), ['class'=>'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('supplier', 'Supplier') !!}
                                        {!! Form::text('supplier', Request::input('supplier'), ['class'=>'form-control']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('purchase_from', 'Purchase Date From') !!}
                                        {!! Form::text('purchase_from', Request::input('purchase_from'), ['class'=>'form-control date', 'autocomplete'=>'off']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('purchase_to', 'Purchase Date To') !!}
                                        {!! Form::text('purchase_to', Request::input('purchase_to'), ['class'=>'form-control date', 'autocomplete'=>'off']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('installation_from', 'Installation Date From') !!}
                                        {!! Form::text('installation_from', Request::input('installation_from'), ['class'=>'form-control date', 'autocomplete'=>'off']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('installation_to', 'Installation Date To') !!}
                                        {!! Form::text('installation_to', Request::input('installation_to'), ['class'=>'form-control date', 'autocomplete'=>'off']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('guarantee', 'Guarantee') !!}
                                        <select class="form-control multiple" name="guarantee">
                                            <option value="0">All</option>
                                            <option value="101"
                                                    @if(101 == Request::input('guarantee')) selected="selected" @endif>
                                                N/A
                                            </option>
                                            @for($i=1; $i<=100; $i++)
                                                <option value="{{ $i }}" @if($i== Request::input('guarantee'))
                                                selected="selected" @endif>{{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('client', 'Client') !!}
                                        {!! Form::select('client', ['0'=>'All'] + $clients, Request::input('client'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('company', 'Company') !!}
                                        {!! Form::select('company', ['0'=>'All'] + $companies, Request::input('company'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('division', 'Division') !!}
                                        {!! Form::select('division', ['0'=>'All'] + $divisions, Request::input('division'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('department', 'Department') !!}
                                        {!! Form::select('department', ['0'=>'All'] + $departments, Request::input('department'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('unit', 'Unit') !!}
                                        {!! Form::select('unit', ['0'=>'All'] + $units, Request::input('unit'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('location', 'Office Location') !!}
                                        {!! Form::select('location', ['0'=>'All'] + $locations, Request::input('location'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('store', 'Asset Store') !!}
                                        {!! Form::select('store', ['0'=>'All'] + $stores, Request::input('store'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('status', 'Status') !!}
                                        {!! Form::select('status', ['0'=>'All'] + $statuses, Request::input('status'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('tag', 'Tag') !!}
                                        {!! Form::select('tag', ['0'=>'All'] + $tags, Request::input('tag'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('service', 'Service') !!}
                                        {!! Form::select('service', ['0'=>'All'] + $services, Request::input('service'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        {!! Form::label('hardware', 'Accessory') !!}
                                        {!! Form::select('hardware', ['0'=>'All'] + $hardwares, Request::input('hardware'), ['class'=>'form-control multiple', 'style'=>'width:100%;']) !!}
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
                                    <th class="" style="min-width:50px;">Client</th>
                                    <th class="" style="min-width:50px;">Company</th>
                                    <th class="" style="min-width:50px;">Asset Location</th>
                                    <th class="" style="min-width:50px;">Workflow</th>
                                    <th class="" style="min-width:50px;">Category</th>
                                    <th class="" style="min-width:50px;">Subcategory</th>
                                    <th class="" style="min-width:50px;">Brand</th>
                                    <th class="" style="min-width:50px;">Model</th>
                                    <th class="" style="min-width:50px;">Supplier</th>
                                    <th class="" style="min-width:50px;">Purchase Value</th>
                                    <th class="" style="min-width:50px;">Is Depreciation</th>
                                    <th class="" style="min-width:50px;">Depreciation Type</th>
                                    <th class="" style="min-width:50px;">Depreciation Category</th>
                                    <th class="" style="min-width:50px;">Depreciation Value</th>
                                    <th class="" style="min-width:50px;">Current Purchase Value</th>
                                    <th class="" style="min-width:50px;">Purchase Date</th>
                                    <th class="" style="min-width:50px;">Installation Date</th>
                                    <th class="" style="min-width:50px;">Guarantee</th>
                                    <th class="" style="min-width:50px;">Division</th>
                                    <th class="" style="min-width:50px;">Department</th>
                                    <th class="" style="min-width:50px;">Unit</th>
                                    <th class="" style="min-width:50px;">Office Location</th>
                                    <th class="" style="min-width:50px;">Store</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Tags</th>
                                    <th class="" style="min-width:50px;">Services</th>
                                    <th class="" style="min-width:50px;">Accessories</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                    <th style="width: 170px">Actions</th>
                                </tr>

                                @foreach($assets as $asset)
                                    <tr>
{{--                                        <td>{{ $asset->id }}</td>--}}
                                        <td>
                                            {{ Config::get('constants.ASSET_ID_PREFIX') . $asset->formattedId }}
                                            <br>
                                            <a data-fancybox="gallery" data-caption="{{ $asset->title }}" href="{{ asset(Helper::storagePath($asset->qr_code_image)) }}">
                                                <img style="width: 100px;" src="{{ asset(Helper::storagePath($asset->qr_code_image)) }}" alt="">
                                            </a>
                                        </td>
                                        <td>{{ $asset->title }}</td>
                                        <td>{{ $asset->client ? $asset->client->name : '' }}</td>
                                        <td>{{ $asset->company ? $asset->company->title : '' }}</td>
                                        <td>
                                        {{ $asset->assign_user ==0 ? $asset->officelocation->title : $asset->user->name }}
                                        </td>
                                        <td>{{ $asset->workflow ? $asset->workflow->title : '' }}</td>
                                        <td>{{ $asset->category ? $asset->category->title : '' }}</td>
                                        <td>{{ $asset->subcategory ? $asset->subcategory->title : '' }}</td>
                                        <td>{{ $asset->brand ? $asset->brand->title : '' }}</td>
                                        <td>{{ $asset->model }}</td>
                                        <td>{{ $asset->supplier }}</td>
                                        <td>{{ $asset->purchase_value }}</td>
                                        <td>{!! Helper::depreciation($asset->is_depreciation)!!}</td>
                                        <td>{!! Helper::depreciationType($asset->depreciation_type)!!}</td>
                                        <td>{!! Helper::depreciationCategory($asset->depreciation_category)!!}</td>
                                        <td>{{ $asset->depreciation_value }}</td>
                                        <td>{{ $asset->current_purchase_value }}</td>
                                        <td>{{ $asset->purchase_date }}</td>
                                        <td>{{ $asset->installation_date }}</td>
                                        <td>{{ $asset->guarantee ? $asset->guarantee : 'N/A' }}</td>
                                        <td>{{ $asset->division ? $asset->division->title : '' }}</td>
                                        <td>{{ $asset->department ? $asset->department->title : '' }}</td>
                                        <td>{{ $asset->unit ? $asset->unit->title : '' }}</td>
                                        <td>{{ $asset->officelocation ? $asset->officelocation->title : '' }}</td>
                                        <td>{{ $asset->store ? $asset->store->title : '' }}</td>
                                        <td>{!! Helper::assetStatuslabel($asset->status)!!}</td>
                                        <td>
                                            @foreach($asset->tags as $tag)
                                                <span class="label label-default">{{ $tag->title }}</span>&nbsp;
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($asset->services as $service)
                                                <span class="label label-default">{{ $service->title }}</span>&nbsp;
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($asset->hardwares as $hardware)
                                                <span class="label label-default">{{ $hardware->title }}</span>&nbsp;
                                            @endforeach
                                        </td>
                                        <td>{{ $asset->created_at->diffForHumans() }}</td>
                                        <td>{{ $asset->updated_at->diffForHumans() }}</td>
                                        <td>
                                            @if(Auth::guard('admin')->user()->hasRole('admin') || Auth::guard('admin')->user()->can(['admin-asset-read']))
                                                <a href="{{ route('admin.assets.show', $asset->id) }}"
                                                   class="btn btn-default btn-sm" title="Detail"><i
                                                        class="fa fa-eye"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </table>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                Page {{ $assets->currentPage() }} , showing {{ $assets->count() }} records out
                                of {{ $assets->total() }} total
                            </ul>
                        </div>

                        <div class="box-footer clearfix">
                            <ul class="pagination pagination-sm no-margin pull-right">
                                {{$assets->appends(Request::all())->links()}}
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

            $(".multiple").select2({
                placeholder: "Choose an option"
            });

            $('.date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $('#installation_date').datepicker({
                autoclose: true,
                format: 'yyyy-mm-dd'
            });

            $("#category_id").on("change", function (e) {
                $('#sub_category_id')
                    .find('option')
                    .remove()
                    .end()
                    .append('<option value="">Loading</option>');
                $('#sub_category_id').trigger('change');

                if ($('#category_id').val() == '') {
                    $('#sub_category_id')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Select District</option>');
                    $('#sub_category_id').trigger('change');
                } else {
                    $.ajax({
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            category_id: $('#category_id').val(),
                            sub_category_id: $('#sub_category_id').val(),
                            index: 1,
                            includeAll: 1
                        },
                        url: "{{ route('admin.getsubcategories') }}",
                        success: function (data) {
                            $('#sub_category_id')
                                .find('option')
                                .remove()
                                .end()
                                .append('<option value="">Choose an option</option>')
                                .append(data);
                            $('#sub_category_id').trigger('change');
                        }
                    });
                }
            });

        });


    </script>

@endsection
