@extends('layouts.backend.app')

@section('title', 'Update Merchants')
@section('maintitle', 'Merchants')
@section('mainUrl',route("admin.merchant.index") )

@push('css')

@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!-- <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 offset-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Update Merchants</li>
                        </ol>
                    </div>
                </div>
            </div> -->
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Merchants</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.merchant.update', $merchant->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="card-body">



                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Merchants Name</label>
                                                <input required type="text" class="form-control" name="name" value="{{ $merchant->name }}" placeholder="Enter Merchants">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Account No.</label>
                                                <input required type="text" class="form-control" name="account_no" value="{{ $merchant->account_no }}" placeholder="Enter Account No.">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact Person</label>
                                                <input required type="text" class="form-control" name="contact_name" value="{{ $merchant->contact_name }}" placeholder="Enter Contact Person">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input required type="text" class="form-control" name="phone" value="{{ $merchant->phone }}" placeholder="Enter Contact Number">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input required type="email" class="form-control" name="email" value="{{ $merchant->email }}" placeholder="Enter E-mail Address">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-md-right">Update Merchants</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@endsection

@push('js')

@endpush
