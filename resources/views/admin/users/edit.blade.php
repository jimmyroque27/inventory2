@extends('layouts.backend.app')

@section('title', 'Update Users')
@section('maintitle', 'Users')
@section('mainUrl',route("admin.users.index") )

@push('css')
<link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/adjust-select.css')}}"/>
@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <br>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Users</h3>
                            </div>
                            <!-- /.card-header -->
                            <form method="post" action="{{ route('admin.users.update', $user->id) }}" >
                              <div class="card-body">
                                   @method('put')
                                  @csrf
                                  <div class="row">
                                      <div class="col-xs-12 col-sm-12">
                                          <div class="form-group">
                                              <strong>Name:</strong>
                                              <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $user->name }}">
                                          </div>
                                      </div>

                                      <div class="col-xs-12 col-sm-12">
                                          <div class="form-group">
                                              <strong>Email:</strong>
                                              <input type="email" name="email" placeholder="Email" class="form-control" readonly value="{{ $user->email }}">
                                          </div>
                                      </div>
                                       
                                      <div class="col-xs-12 col-sm-12 col-md-12">
                                          <div class="form-group">
                                              <strong>Role: </strong>
                                              <select class="custom-select custom-select-lg" name="roles[]" >
                                                @foreach($roles as $role)
                                                  <option value="{{ $role->id }}" @if(in_array($role->id, $userRoles) ) selected @endif> {{ $role->name }} </option>
                                                @endforeach
                                              </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <!-- /.card-body -->
                              <div class="card-footer">

                                    <button type="submit" class="btn btn-primary float-right">Update</button>

                              </div>
                              <!-- /.card-footer -->
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
