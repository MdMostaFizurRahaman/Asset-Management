@extends('layouts.admin')

@section('content')

<div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> Client Info</h1>
        <ol class="breadcrumb">
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Client Info</h3>
                    </div>
                    <div class="box-body">
                        <table class="table table-responsive table-striped table-bordered">
                            <tr>
                                <th style="width: 20%;">Name</th>
                                <td style="width: 80%;">{{ $client->name }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Primary Email</th>
                                <td style="width: 80%;">{{ $client->email }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Secondary Email</th>
                                <td style="width: 80%;">{{ $client->secondary_email }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Phone</th>
                                <td style="width: 80%;">{{ $client->phone }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Active</th>
                                <td style="width: 80%;">{!! Helper::activeClientStatuslabel($client->status) !!}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Client Website</th>
                                <td style="width: 80%;">{{ $client->client_website }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Client URL</th>
                                <td style="width: 80%;"><a target="_blank" href="http://{{$client->client_url.'.' . env('APP_DOMAIN_URL') }}">{{$client->client_url.'.' . env('APP_DOMAIN_URL') }}</a></td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Name</th>
                                <td style="width: 80%;">{{ $client->contact_person_name }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Phone</th>
                                <td style="width: 80%;">{{ $client->contact_person_phone }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Secondary Phone</th>
                                <td style="width: 80%;">{{ $client->contact_person_secondary_phone }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Contact Person Email</th>
                                <td style="width: 80%;">{{ $client->contact_person_email }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Address</th>
                                <td style="width: 80%;">{{ $client->address }}</td>
                            </tr>

                            <tr>
                                <th style="width: 20%;">Created At</th>
                                <td style="width: 80%;">{{ $client->created_at->diffForHumans() }}</td>
                            </tr>
                            <tr>
                                <th style="width: 20%;">Updated At</th>
                                <td style="width: 80%;">{{ $client->updated_at->diffForHumans() }}</td>
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
