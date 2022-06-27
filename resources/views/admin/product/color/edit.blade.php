@extends('layouts.backend.app')

@section('title', 'Update Color')
@section('maintitle', 'Colors')
@section('mainUrl',route("admin.product.color.index") )

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
                            <li class="breadcrumb-item active">Update Color</li>
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
                                <h3 class="card-title">Update Color</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            @foreach($colors as $color)
                              <form role="form" action="{{ route('admin.product.color.update', $color->id) }}" method="post">
                                  @csrf
                                  @method('PUT')

                                  <div class="card-body">
                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-group">
                                                  <label>Color Name </label>
                                                  <input type="text" class="form-control" name="name" value="{{ $color->name }}" placeholder="Enter Color Name">
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                                  <!-- /.card-body -->
                                  <div class="card-footer">
                                      <button type="submit" class="btn btn-primary float-md-right">Update Color</button>
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
