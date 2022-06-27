 @extends('layouts.backend.app')

@section('title', 'Show Roles')
@section('maintitle', 'Roles')
@section('mainUrl',route("admin.role.index") )

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
                                <h3 class="card-title">Show Users</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->


                                <div class="card-body">
                                  <div class="container">
                                    <div class="row">
                                            <div class="col-lg-12 margin-tb">
                                                @if ($message = Session::get('success'))
                                                <div class="alert alert-success">
                                                  <p>{{ $message }}</p>
                                                </div>
                                                @endif
                                                <table class="table table-bordered">
                                                 <tr>
                                                   <th></th>
                                                   <th>Name</th>
                                                   <th>Action</th>
                                                 </tr>
                                                 @foreach ($roles as $key => $role)
                                                  <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $role->name }}</td>
                                                    <td>
                                                       <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                                       @can('role-edit')
                                                        <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                                       @endcan
                                                        @can('role-delete')
                                                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </td>
                                                  </tr>
                                                 @endforeach
                                                </table>
                                            </div>
                                        </div>


                                  </div>



                                </div>
                                <!-- /.card-body -->

                        </div>
                        <!-- /.card -->
                    </div>role
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
