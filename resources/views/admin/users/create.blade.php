@extends('layouts.backend.app')

@section('title', 'Create Users')
@section('maintitle', 'Users')
@section('mainUrl',route("admin.users.index") )

@push('css')

@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Create Users</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form action="{{ route('admin.users.store') }}" method="post">

                              @csrf
                               <div class="row">
                                   <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                           <strong>Name:</strong>
                                           <input type="text" name="name" placeholder="Name" class="form-control">
                                       </div>
                                   </div>

                                   <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                           <strong>Email:</strong>
                                           <input type="email" name="email" placeholder="Email" class="form-control">
                                       </div>
                                   </div>

                                   <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                           <strong>Password:</strong>
                                           <input type="password" name="password" placeholder="Password" class="form-control">
                                       </div>
                                   </div>

                                   <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                           <strong>Confirm Password:</strong>
                                           <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control">
                                       </div>
                                   </div>

                                   <div class="col-xs-12 col-sm-12 col-md-12">
                                       <div class="form-group">
                                           <strong>Role:</strong>
                                           <select class="custom-select custom-select-lg mb-3" name="roles[]" >
                                             <option selected>Select Role</option>
                                             @foreach($roles as $role)
                                               <option value="{{ $role->id }}"> {{ $role->name }} </option>
                                             @endforeach
                                           </select>
                                       </div>
                                   </div>

                                   <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                       <button type="submit" class="btn btn-primary">Submit</button>
                                   </div>
                               </div>
                           </form>
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
