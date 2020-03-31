@extends('layouts.admin')

@section('content')

<div class="content-wrapper" style="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Change Password</h1>
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
                        <h3 class="box-title">Change Password</h3>
                    </div>

                    @include('include.error')
                    @include('include.flashMessage')

                    {!! Form::model($vendor, ['method'=>'PATCH', 'action'=>['admin\VendorController@resetPasswordStore', $vendor->id]]) !!}

                    <div class="box-body">
                        <div class="col-md-4">

                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                <input class="form-control" disabled="disabled" type="text" value="{{ $vendor->name }}">
                            </div>
                            <div class="form-group">
                                {!! Form::label('username', 'User Id') !!}
                                <input name="username" class="form-control" disabled="disabled" type="text" value="{{ $vendor->username }}{{ $vendor->vendorInfo ? '@'.$vendor->vendorInfo->vendor_id: '@' }}">
                            </div>
                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!}
                                <input class="form-control" disabled="disabled" type="text" value="{{ $vendor->email }}">
                            </div>

                            <div class="form-group">
                                {!! Form::label('password', 'New Password') !!}
                                {!! Form::password('password', ['class'=>'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('password_confirmation', 'Confirm Password') !!}
                                {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
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


