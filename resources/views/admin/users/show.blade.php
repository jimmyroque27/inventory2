 @extends('layouts.backend.app')

@section('title', 'Show Users')
@section('maintitle', 'Users')
@section('mainUrl',route("admin.users.index") )

@push('css')

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
                                       <div class="col-xs-12 col-sm-12 col-md-12">
                                           <div class="form-group">
                                               <strong>Name:</strong>
                                               {{ $user->name }}
                                           </div>
                                       </div>

                                       <div class="col-xs-12 col-sm-12 col-md-12">
                                           <div class="form-group">
                                               <strong>Email:</strong>
                                               {{ $user->email }}
                                           </div>
                                       </div>

                                       <div class="col-xs-12 col-sm-12 col-md-12">
                                           <div class="form-group">
                                               <strong>Roles:</strong>
                                               @if(!empty($user->getRoleNames()))
                                                   @foreach($user->getRoleNames() as $role)
                                                       <label class="badge badge-success">{{ $role }}</label>
                                                   @endforeach
                                               @endif
                                           </div>
                                       </div>
                                   </div>

                                  </div>



                                </div>
                                <!-- /.card-body -->

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
