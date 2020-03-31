@extends('layouts.client')
@section('content')

    <div class="content-wrapper" style="">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Details Info</h1>
            <ol class="breadcrumb">
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Details</h3>
                        </div>
                        @include('include.flashMessage')
                        @include('include.error')

                        <div class="box-body">
                            <table class="table table-responsive table-striped table-bordered">

                                <tr>
                                    <th style="width: 20%;">Name</th>
                                    <td style="width: 80%;">{{ $client->name ? $client->name : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Email</th>
                                    <td style="width: 80%;">{{ $client->email ? $client->email : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Phone</th>
                                    <td style="width: 80%;">{{ $client->phone ? $client->phone : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Designation</th>
                                    <td style="width: 80%;">{{ $client->designation ? $client->designation->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Client</th>
                                    <td style="width: 80%;">{{ $client->client ? $client->client->name : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Company</th>
                                    <td style="width: 80%;">{{ $client->company ? $client->company->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Office Location</th>
                                    <td style="width: 80%;">{{ $client->officelocation ? $client->officelocation->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Division</th>
                                    <td style="width: 80%;">{{ $client->division ? $client->division->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Department</th>
                                    <td style="width: 80%;">{{ $client->department ? $client->department->title : '' }}</td>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">Created At</th>
                                    <td style="width: 80%;">{{ $client->created_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Updated At</th>
                                    <td style="width: 80%;">{{ $client->updated_at->diffForHumans() }}</td>
                                </tr>
                                <tr>
                                    <th style="width: 20%;">Assigned Assets List</th>
                                </tr>
                            </table>
                            <div class="box-body table-responsive ">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                    <tr>
                                        <th class="" style="min-width:50px;">SN.</th>
                                        <th class="" style="min-width:50px;">Asset Title</th>
                                        <th class="" style="min-width:50px;">Description</th>
                                        <th class="" style="min-width:50px;">Status</th>
                                        <th class="" style="min-width:50px;">Created At</th>
                                        <th class="" style="min-width:50px;">Updated At</th>
                                        <th style="width: 170px">Action</th>
                                    </tr>
                                    @foreach($client->assets as $asset)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $asset->title }}</td>
                                            <td>{{ $asset->note }}</td>
                                            <td>{!! Helper::assetAssignStatusLabel($asset->accept_reject_status) !!}</td>
                                            <td>{{ $asset->created_at->diffForHumans() }}</td>
                                            <td>{{ $asset->updated_at->diffForHumans() }}</td>
                                            <td>
                                                @if($asset->accept_reject_status==1)
                                                    <a title="Return Asset" href="{{ route('client.assetreturn', [$subdomain, $asset->id]) }}"
                                                       class="btn btn-default btn-sm"><i class="fa fa-rotate-left"></i></a>
                                                @endif
                                                @if($asset->accept_reject_status == 0)

                                                    <a href="#" class="btn btn-default btn-sm" title="Accept"
                                                       onclick="if (confirm(&quot;Are you sure you want to accept ?&quot;)) { document.getElementById('acceptForm{{ $asset->id }}').submit(); } event.returnValue = false; return false;"><i
                                                            class="fa fa-check"></i></a>
                                                    {!! Form::open(['method'=>'POST', 'action'=>['client\ClientController@assetacceptstore', $subdomain, $asset->id], 'id'=>'acceptForm'.$asset->id,'style'=>'display:none']) !!}
                                                    {!! Form::close() !!}

                                                    <a title="Reject" href="{{ route('client.assetreject', [$subdomain, $asset->id]) }}"
                                                       class="btn btn-default btn-sm"><i class="fa fa-ban"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

@endsection
