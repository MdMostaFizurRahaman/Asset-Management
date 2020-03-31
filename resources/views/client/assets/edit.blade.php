@extends('layouts.client')

@section('content')

    <div class="content-wrapper" style="">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1> Edit Asset </h1>
            <ol class="breadcrumb">
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">


            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Asset Brand Info</h3>
                        </div>

                        @include('include.error')

                        {!! Form::model($asset, ['method'=>'PATCH', 'action'=>['client\AssetController@update', $subdomain, $asset->id], 'files'=>true]) !!}

                        <div class="box-body">
                            <div class="col-md-6">

                                <div class="form-group">
                                    {!! Form::label('title', 'Title') !!}
                                    {!! Form::text('title', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('category_id', 'Category') !!}
                                    {!! Form::select('category_id', [''=>'Choose an option']+$categories, null, ['class'=>'form-control multiple']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('sub_category_id', 'Subcategory') !!}
                                    {!! Form::select('sub_category_id', [''=>'Choose an option']+$subcategories, null, ['class'=>'form-control multiple']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('brand_id', 'Brand') !!}
                                    {!! Form::select('brand_id', [''=>'Choose an option']+$brands, null, ['class'=>'form-control multiple']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('model', 'Model') !!}
                                    {!! Form::text('model', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('specification', 'Specification') !!}
                                    {!! Form::textarea('specification', null, ['class'=>'form-control resize-vertical', 'size' => '30x4']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('supplier', 'Supplier Name') !!}
                                    {!! Form::text('supplier', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('vendor', 'O&M Vendor Name') !!}
                                    {!! Form::text('vendor', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('purchase_value', 'Purchase Value') !!}
                                    {!! Form::text('purchase_value', null, ['class'=>'form-control', 'autocomplete'=>'off']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::checkbox('is_depreciation', '1', null, ['id'=>'is_depreciation', 'class'=>'']) !!}
                                    {!! Form::label('is_depreciation', '&nbsp;Is Depreciation') !!}
                                </div>

                                <div id="depreciation">
                                    <div class="form-group">
                                        {!! Form::label('depreciation_type', 'Depreciation Type') !!}
                                        {!! Form::select('depreciation_type', [''=>'Choose an option']+Config::get('constants.DEPRECIATION_TYPE'), null, ['class'=>'form-control multiple']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('depreciation_category', 'Depreciation Category') !!}
                                        {!! Form::select('depreciation_category', [''=>'Choose an option']+Config::get('constants.DEPRECIATION_CATEGORY'), null, ['class'=>'form-control multiple']) !!}
                                    </div>

                                    <div class="form-group">
                                        {!! Form::label('depreciation_value', 'Depreciation Value') !!}
                                        {!! Form::text('depreciation_value', null, ['class'=>'form-control', 'autocomplete'=>'off']) !!}
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('purchase_date', 'Purchase Date') !!}
                                    {!! Form::text('purchase_date', null, ['class'=>'form-control', 'autocomplete'=>'off']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('installation_date', 'Installation Date') !!}
                                    {!! Form::text('installation_date', null, ['class'=>'form-control', 'autocomplete'=>'off']) !!}
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    {!! Form::label('guarantee', 'Guarantee') !!}
                                    <select class="form-control multiple" id="guarantee" name="guarantee">
                                        <option value="0" @if(0 == old('guarantee')) selected="selected" @endif>N/A
                                        </option>
                                        @for($i=1; $i<=100; $i++)
                                            <option value="{{ $i }}" @if($i== old('guarantee'))
                                            selected="selected" @endif>{{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    {!! Form::label('company_id', 'Company') !!}
                                    {!! Form::select('company_id', [''=>'Choose an option']+$companies, null, ['class'=>'form-control multiple']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('division_id', 'Division') !!}
                                    {!! Form::select('division_id', [''=>'Choose an option']+$divisions, null, ['class'=>'form-control multiple']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('department_id', 'Department') !!}
                                    {!! Form::select('department_id', [''=>'Choose an option']+$departments, null, ['class'=>'form-control multiple']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('unit_id', 'Unit') !!}
                                    {!! Form::select('unit_id', [''=>'Choose an option']+$units, null, ['class'=>'form-control multiple']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('office_location_id', 'Office Location') !!}
                                    {!! Form::select('office_location_id', [''=>'Choose an option']+$locations, null, ['class'=>'form-control multiple']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('store_id', 'Asset Store') !!}
                                    {!! Form::select('store_id', [''=>'Choose an option']+$stores, null, ['class'=>'form-control multiple']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('status', 'Status') !!}
                                    {!! Form::select('status', [''=>'Choose an option']+$statuses, null, ['class'=>'form-control multiple']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('tags', 'Tag') !!}
                                    {!! Form::select('tags[]', $tags, null, ['class'=>'form-control multiple', 'multiple'=>true]) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('services', 'Service') !!}
                                    {!! Form::select('services[]', $services, null, ['class'=>'form-control multiple', 'multiple'=>true]) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('hardwares', 'Accessory') !!}
                                    {!! Form::select('hardwares[]', $hardwares, null, ['class'=>'form-control multiple', 'multiple'=>true]) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('image', 'Image') !!}
                                    {!! Form::file('image', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('workflow_id', 'Workflow') !!}
                                    {!! Form::select('workflow_id', [''=>'Choose an option']+$workflows, null, ['class'=>'form-control multiple']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('note', 'Note') !!}
                                    {!! Form::textarea('note', null, ['class'=>'form-control resize-vertical', 'size' => '30x4']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::checkbox('archive', '1', null, ['id'=>'archive', 'class'=>'form-control']) !!}
                                    {!! Form::label('archive', '&nbsp;Archive') !!}
                                </div>

                            </div>
                        </div>

                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">
                    <!-- Horizontal Form -->

                    <!-- /.box -->
                    <!-- general form elements disabled -->

                    <!-- /.box -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

@endsection


@section('scripts')

    <script>

        $(function () {

            $('input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
            });
            // Show hide depreciation
            $('#is_depreciation').on('ifChanged', function (event) {

                if ($(this).is(':checked')) {
                    $("#depreciation").show();
                } else {
                    $("#depreciation").hide();

                    $("#depreciation_type").val('');
                    $("#depreciation_category").val('');
                    $("#depreciation_value").val('');
                }

            });
            $(".multiple").select2({
                placeholder: "Choose an option"
            });

            $('#purchase_date').datepicker({
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
                            includeAll: 1
                        },
                        url: "{{ route('client.getsubcategories', $subdomain) }}",
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
