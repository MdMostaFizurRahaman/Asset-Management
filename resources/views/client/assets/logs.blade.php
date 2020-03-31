@extends('layouts.client')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Asset Log Information </h1>

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
                                    <td>{!! Helper::assetStatuslabel($asset->status)!!}</td>
                                    <td>{{ $asset->created_at->diffForHumans() }}</td>
                                    <td>{{ $asset->updated_at->diffForHumans() }}</td>
                                </tr>

                            </table>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-header with-border">
                            <h3 class="box-title">All logs</h3>
                        </div>

                        <div class="box-body">
                            @foreach($asset->logs as $logs)
                                <div class="info-box logs">
                                    {!! Helper::assetStageIconBg($logs->type) !!}
                                    <div class="info-box-content">
                                            <span
                                                class="info-box-text text-bold text-purple">{!! Helper::assetStage($logs->type) !!}</span>
                                        <span class="info-box-text"><strong>Action By: </strong>{{ $logs->actionUser->name }}</span>
                                        @if($logs->type == 1 || $logs->type == 2 || $logs->type == 4 )
                                            <span class="info-box-text"><strong>Initial Store: </strong>{{ $logs->store->title ?? '' }}</span>
                                        @endif
                                        @if($logs->type == 3 && $logs->assign_user != 0)
                                            <span class="info-box-text"><strong>Assign User: </strong>{{ $logs->assignUser->name ?? ''}}</span>
                                        @endif
                                        @if($logs->type == 5)
                                            <span class="info-box-text"><strong>Return Store: </strong>{{ $logs->store->title ?? '' }}</span>
                                        @endif
                                        @if($logs->type == 6)
                                            <span class="info-box-text"><strong>Return Store: </strong>{{ $logs->returnStore->title ?? '' }}</span>
                                        @endif
                                        @if($logs->type == 7)
                                            <span class="info-box-text"><strong>Return Store: </strong>{{ $logs->store->title ?? '' }}</span>
                                        @endif
                                        @if($logs->type == 8 && $logs->assign_user != 0)
                                            <span class="info-box-text"><strong>Assign User: </strong>{{ $logs->assignUser->name ?? ''}}</span>
                                        @endif
                                        @if($logs->type == 9)
                                            <span class="info-box-text"><strong>From: </strong>{{ $logs->storeFrom->title ?? 'Not Found'}} ({{ $logs->storeFrom->locations->title ?? 'Not Found'}}) </span>
                                            <span class="info-box-text"><strong>To: </strong>{{ $logs->storeTo->title ?? 'Not Found'}} ({{ $logs->storeTo->locations->title ?? 'Not Found'}})</span>
                                        @endif
                                        <span
                                            class="info-box-text"><strong>Note: </strong><small>{{ $logs->note ?? ''}}</small></span>
                                        <span class="log time"><i class="fa fa-clock-o"></i> {{ $logs->created_at->format('h:i:s a / d-M-Y') }}</span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            @endforeach
                        </div>
                        <!-- /.box-body -->
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

            //For getting associate store after changing office location
            $('#office_location_id').on('change', function () {
                if ($(this).val() != '') {
                    const office_location_id = $(this).val();
                    const csrf_token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('client.assetstore', $subdomain) }}',
                        method: 'POST',
                        data: {'office_location_id': office_location_id, '_token': csrf_token},
                        //must be send csrf_token exactly to _token name otherwise not work
                        success: function (data) {
                            $('#store_id').html(data);
                        }
                    });
                } else {
                    $('#store_id').html('');
                }
            })
        });
    </script>

@endsection
