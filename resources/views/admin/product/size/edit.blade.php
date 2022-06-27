@extends('layouts.backend.app')

@section('title', 'Update Size')
@section('maintitle', 'Sizes')
@section('mainUrl',route("admin.product.size.index") )

@push('css')

@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 offset-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Update Size</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- /.container-fluid -->

        <br>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Size</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            @foreach($sizes as $size)
                              <form role="form" action="{{ route('admin.product.size.update', $size->id) }}" method="post">
                                  @csrf
                                  @method('PUT')

                                  <div class="card-body">
                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label>Size Name </label>
                                                  <input type="text" class="form-control" name="name" value="{{ $size->name }}" placeholder="Enter Size Name">
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- /.card-body -->
                                  <div class="card-footer">
                                      <button type="submit" class="btn btn-primary float-md-right">Update Size</button>
                                  </div>
                              </form>
                            @endforeach
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
