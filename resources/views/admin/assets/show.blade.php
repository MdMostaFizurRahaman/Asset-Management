@extends('layouts.admin')

@section('content')

    <div class="content-wrapper" style="">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Asset Info</h1>
            <ol class="breadcrumb">
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Asset Info</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-responsive table-striped table-bordered">

                                <tr>
                                    <th style="width: 20%;">Title</th>
                                    <td style="width: 80%;">{{ $asset->title ? $asset->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Workflow</th>
                                    <td style="width: 80%;">{{ $asset->workflow ? $asset->workflow->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Category</th>
                                    <td style="width: 80%;">{{ $asset->category ? $asset->category->title : '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Subcategory</th>
                                    <td style="width: 80%;">{{ $asset->subcategory ? $asset->subcategory->title : '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Brand</th>
                                    <td style="width: 80%;">{{ $asset->brand ? $asset->brand->title : '' }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Model</th>
                                    <td style="width: 80%;">{{ $asset->model }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Specification</th>
                                    <td style="width: 80%;">{{ $asset->specification }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Note</th>
                                    <td style="width: 80%;">{{ $asset->note }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Supplier Name</th>
                                    <td style="width: 80%;">{{ $asset->supplier }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">O&M Vendor Name</th>
                                    <td style="width: 80%;">{{ $asset->vendor }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Purchase Value</th>
                                    <td>{{ $asset->purchase_value }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Is Depreciation</th>
                                    <td>{!! Helper::depreciation($asset->is_depreciation)!!}</td>

                                </tr>

                                <tr>
                                    <th style="width: 20%;">Depreciation Type</th>
                                    <td>{!! Helper::depreciationType($asset->depreciation_type)!!}</td>

                                </tr>

                                <tr>
                                    <th style="width: 20%;">Depreciation Category</th>
                                    <td>{!! Helper::depreciationCategory($asset->depreciation_category)!!}</td>

                                </tr>

                                <tr>
                                    <th style="width: 20%;">Depreciation Value</th>
                                    <td>{{ $asset->depreciation_value }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Current Purchase Value</th>
                                    <td>{{ $asset->current_purchase_value }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">O&M Vendor Name</th>
                                    <td style="width: 80%;">{{ $asset->vendor }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Purchase Date</th>
                                    <td style="width: 80%;">{{ $asset->purchase_date }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Installation Date</th>
                                    <td style="width: 80%;">{{ $asset->installation_date }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Guarantee</th>
                                    <td style="width: 80%;">{{ $asset->guarantee ? $asset->guarantee : 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Client</th>
                                    <td style="width: 80%;">{{ $asset->client ? $asset->client->name : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Company</th>
                                    <td style="width: 80%;">{{ $asset->company ? $asset->company->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Division</th>
                                    <td style="width: 80%;">{{ $asset->division ? $asset->division->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Department</th>
                                    <td style="width: 80%;">{{ $asset->department ? $asset->department->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Unit</th>
                                    <td style="width: 80%;">{{ $asset->unit ? $asset->unit->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Office Location</th>
                                    <td style="width: 80%;">{{ $asset->officelocation ? $asset->officelocation->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Asset Store</th>
                                    <td style="width: 80%;">{{ $asset->store ? $asset->store->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Status</th>
                                    <td style="width: 80%;">{!! Helper::assetStatuslabel($asset->status) !!}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Archive</th>
                                    <td style="width: 80%;">{!! Helper::activeArchivelabel($asset->archive) !!}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Image</th>
                                    <td style="width: 80%;">
                                        <img style="height: 100px;"
                                             src="{{ asset(Helper::storagePath($asset->image)) }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Tags</th>
                                    <td style="width: 80%;">
                                        @foreach($asset->tags as $tag)
                                            <span class="label label-default">{{ $tag->title }}</span>&nbsp;
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Services</th>
                                    <td style="width: 80%;">
                                        @foreach($asset->services as $service)
                                            <span class="label label-default">{{ $service->title }}</span>&nbsp;
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Accessories</th>
                                    <td style="width: 80%;">
                                        @foreach($asset->hardwares as $hardware)
                                            <span class="label label-default">{{ $hardware->title }}</span>&nbsp;
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Created At</th>
                                    <td style="width: 80%;">{{ $asset->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated At</th>
                                    <td style="width: 80%;">{{ $asset->updated_at->diffForHumans() }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

@endsection
