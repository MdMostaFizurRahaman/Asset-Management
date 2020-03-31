@extends('layouts.admin')

@section('content')

<div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Vendor Info</h1>
        <ol class="breadcrumb">
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Vendor Info</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-striped table-bordered">
                            <tr>
                                <th style="width: 20%;">Name</th>
                                <td style="width: 80%;">{{ $vendorinfo->name }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Primary Email</th>
                                <td style="width: 80%;">{{ $vendorinfo->email }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Secondary Email</th>
                                <td style="width: 80%;">{{ $vendorinfo->secondary_email ?? 'Not Found' }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Phone</th>
                                <td style="width: 80%;">{{ $vendorinfo->phone }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Active</th>
                                <td style="width: 80%;">{!! Helper::activeVendorInfoStatusLabel($vendorinfo->status) !!}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Vendor Website</th>
                                <td style="width: 80%;">{{ $vendorinfo->vendor_web_url ?? 'Not Found' }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Vendor Url</th>
                                <td style="width: 80%;"><a target="_blank" href="http://{{ 'vendor.' . env('APP_DOMAIN_URL') }}">{{ 'vendor.' . env('APP_DOMAIN_URL') }}</a></td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Vendor Unique Identity</th>
                                <td style="width: 80%;">{{ $vendorinfo->vendor_id }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Name</th>
                                <td style="width: 80%;">{{ $vendorinfo->contact_person_name }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Phone</th>
                                <td style="width: 80%;">{{ $vendorinfo->contact_person_phone }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Secondary Phone</th>
                                <td style="width: 80%;">{{ $vendorinfo->contact_person_secondary_phone }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Email</th>
                                <td style="width: 80%;">{{ $vendorinfo->contact_person_email }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Address</th>
                                <td style="width: 80%;">{{ $vendorinfo->address }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Created At</th>
                                <td style="width: 80%;">{{ $vendorinfo->created_at->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Updated At</th>
                                <td style="width: 80%;">{{ $vendorinfo->updated_at->diffForHumans() }}</td>
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
