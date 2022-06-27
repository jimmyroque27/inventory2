@extends('layouts.backend.app')

@section('title', 'Update Roles')
@section('maintitle', 'Roles')
@section('mainUrl',route("admin.roles.index") )

@push('css')

@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Update Users</h3>
                            </div>
                            <!-- /.card-header -->

                            <form method="post" action="{{ route('admin.roles.update', $role->id) }}" >
                              @method('put')
                              @csrf
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Name:</strong>
                                            <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $role->name }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Permission:</strong>
                                            <select class="custom-select custom-select-lg mb-3" name="permissions[]" multiple>
                                              <option selected>Select Permission</option>
                                              @foreach($permissions as $permission)
                                                <option value="{{ $permission->id }}" @if(in_array($permission->id, $rolePermissions) ) selected @endif> {{ $permission->name }} </option>
                                              @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
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
