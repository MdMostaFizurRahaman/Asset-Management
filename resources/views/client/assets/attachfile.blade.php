@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Attach File </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Asset Info</h3>
                        </div>

                    @include('include.flashMessage')
                    @include('include.error')

                    <!-- /.box-header -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">ID</th>
                                    <th class="" style="min-width:50px;">Title</th>
                                    <th class="" style="min-width:50px;">Company</th>
                                    <th class="" style="min-width:50px;">Office Location</th>
                                    <th class="" style="min-width:50px;">Store</th>
                                    <th class="" style="min-width:50px;">Status</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                </tr>

                                <tr>
                                    <td>{{ $asset->id }}</td>
                                    <td>{{ $asset->title }}</td>
                                    <td>{{ $asset->company? $asset->company->title : '' }}</td>
                                    <td>{{ $asset->officelocation ? $asset->officelocation->title : '' }}</td>
                                    <td>{{ $asset->store ? $asset->store->title : '' }}</td>
                                    <td>{!! Helper::assetStatuslabel($asset->status) !!}</td>
                                    <td>{{ $asset->created_at->diffForHumans() }}</td>
                                    <td>{{ $asset->updated_at->diffForHumans() }}</td>
                                </tr>

                            </table>
                        </div>
                        <!-- /.box-body -->

                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-assets-update'))

                            <div class="box-header with-border">
                                <h3 class="box-title">Attach File</h3>
                            </div>

                            {!! Form::open(['method'=>'POST', 'action'=>['client\AssetController@attachfilestore', $subdomain, $asset->id], 'files'=>true]) !!}
                            <div class="box-body">

                                <div class="col-md-6">

                                    <div class="form-group">
                                        {!! Form::label('title', 'Title') !!}
                                        {!! Form::text('title', null, ['class'=>'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('file', 'File') !!}
                                        {!! Form::file('file', null, ['class'=>'form-control']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('note', 'Note') !!}
                                        {!! Form::textarea('note', null, ['class'=>'form-control resize-vertical', 'size' => '30x4']) !!}
                                    </div>
                                </div>
                            </div>

                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        {!! Form::close() !!}
                    @endif
                    <!-- /.box-body -->

                        <!-- /.box-header -->
                        <div class="box-header with-border">
                            <h3 class="box-title">Attachment List</h3>
                        </div>
                        <!-- box-body -->
                        <div class="box-body table-responsive ">
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th class="" style="min-width:50px;">SN.</th>
                                    <th class="" style="min-width:50px;">Title</th>
                                    <th class="" style="min-width:50px;">Note</th>
                                    <th class="" style="min-width:50px;">Uploaded By</th>
                                    <th class="" style="min-width:50px;">Created At</th>
                                    <th class="" style="min-width:50px;">Updated At</th>
                                    <th style="width: 170px">Actions</th>
                                </tr>
                                @foreach($attachments as $attachment)
                                <tr>
                                    <td>{{ $attachment->id }}</td>
                                    <td>
                                        <a target="_blank" href="http://{{ Helper::storagePath($attachment->filename) }}">{{ $attachment->title }}</a>
                                    </td>
                                    <td>{{ $attachment->note }}</td>
                                    <td>{{ $attachment->users->name }}</td>
                                    <td>{{ $attachment->created_at->diffForHumans() }}</td>
                                    <td>{{ $attachment->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if(Auth::user()->hasRole('admin') || Auth::user()->can('client-attachment-delete'))

                                            <a href="#" class="btn btn-default btn-sm" title="Delete"
                                               onclick="if (confirm(&quot;Are you sure you want to delete ?&quot;)) { document.getElementById('deleteForm{{ $attachment->id }}').submit(); } event.returnValue = false; return false;"><i
                                                    class="fa fa-trash"></i></a>

                                            {!! Form::open(['method'=>'DELETE', 'action'=>['client\AssetController@attachmentdestroy', $subdomain, $attachment->id], 'id'=>'deleteForm'.$attachment->id]) !!}
                                            {!! Form::close() !!}
                                        @endif

                                    </td>
                                </tr>
                                @endforeach
                            </table>
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


@endsection
