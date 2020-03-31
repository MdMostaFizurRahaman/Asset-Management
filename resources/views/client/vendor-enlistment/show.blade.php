@extends('layouts.client')

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
                        <h3 class="box-title">Enlistment Vendor Info</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-striped table-bordered">
                            <tr>
                                <th style="width: 20%;">Name</th>
                                <td style="width: 80%;">{{ $enlistvendor->vendors->name }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Primary Email</th>
                                <td style="width: 80%;">{{ $enlistvendor->vendors->email }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Secondary Email</th>
                                <td style="width: 80%;">{{ $enlistvendor->vendors->secondary_email ?? 'Not Found' }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Phone</th>
                                <td style="width: 80%;">{{ $enlistvendor->vendors->phone }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Active</th>
                                <td style="width: 80%;">{!! Helper::activeStatuslabel($enlistvendor->status) !!}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Vendor Website</th>
                                <td style="width: 80%;">{{ $enlistvendor->vendors->vendor_web_url ?? 'Not Found' }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Vendor Unique Identity</th>
                                <td style="width: 80%;">{{ $enlistvendor->vendors->vendor_id }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Name</th>
                                <td style="width: 80%;">{{ $enlistvendor->vendors->contact_person_name }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Phone</th>
                                <td style="width: 80%;">{{ $enlistvendor->vendors->contact_person_phone }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Secondary Phone</th>
                                <td style="width: 80%;">{{ $enlistvendor->vendors->contact_person_secondary_phone }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Email</th>
                                <td style="width: 80%;">{{ $enlistvendor->vendors->contact_person_email }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Address</th>
                                <td style="width: 80%;">{{ $enlistvendor->vendors->address }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Enlistment Date</th>
                                <td style="width: 80%;">{{ $enlistvendor->enlist_date ? Carbon\Carbon::parse($enlistvendor->enlist_date)->format('Y-m-d') : '' }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Enlistment End Date</th>
                                <td style="width: 80%;">{{ $enlistvendor->enlist_end_date? Carbon\Carbon::parse($enlistvendor->enlist_end_date)->format('Y-m-d') : ''}}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Created At</th>
                                <td style="width: 80%;">{{ $enlistvendor->created_at->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Updated At</th>
                                <td style="width: 80%;">{{ $enlistvendor->updated_at->diffForHumans() }}</td>
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
