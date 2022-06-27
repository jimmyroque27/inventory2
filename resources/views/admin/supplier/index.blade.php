@extends('layouts.backend.app')

@section('title', 'Suppliers')
@section('maintitle', 'Dashboard')
@section('mainUrl',route("admin.dashboard") )

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/adjust-select.css')}}"/>
@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!-- <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 offset-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Supplier</li>
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
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">SUPPLIERS LISTS
                                  <?php
                                    $addBtn = route('admin.supplier.create');
                                    $BtnCaption = "Add Supplier" ;
                                  ?>
                                  @include('includes._datatable_actions')
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center">
                                    <thead>
                                    <tr>
                                        <th>Id No.</th>
                                        <th>Name</th>
                                        <th>Shop Name</th>
                                        <th>Type</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>City</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                      <!-- @foreach($suppliers as $key => $supplier)
                                          <tr>
                                              <td>{{ $key + 1 }}</td>
                                              <td>{{ $supplier->name }}</td>
                                              <td>
                                                  <img class="img-rounded" style="height:35px; width: 35px;" src="{{ URL::asset("storage/supplier/".$supplier->photo) }}" alt="{{ $supplier->name }}">
                                              </td>
                                              <td>{{ $supplier->email }}</td>
                                              <td>0{{ $supplier->phone }}</td>
                                              <td>{{ $supplier->address }}</td>
                                              <td>{{ $supplier->city }}</td>
                                              <td>
                                                  @if($supplier->type == 1)
                                                      {{ 'Distributor' }}
                                                  @elseif($supplier->type == 2)
                                                      {{ 'Whole Seller' }}
                                                  @elseif($supplier->type == 3)
                                                      {{ 'Brochure' }}
                                                  @else
                                                      {{ 'None' }}
                                                  @endif
                                              </td>
                                              <td>{{ $supplier->shop_name }}</td>
                                              <td>{{ $supplier->account_holder }}</td>
                                              <td>{{ $supplier->account_number }}</td>
                                              <td>{{ $supplier->bank_name }}</td>
                                              <td>{{ $supplier->bank_branch }}</td>
                                              <td>
                                                  <a href="{{ route('admin.supplier.show', $supplier->id) }}" class="btn btn-success">
                                                      <i class="fa fa-eye" aria-hidden="true"></i>
                                                  </a>
                                                  <a href="{{ route('admin.supplier.edit', $supplier->id) }}" class="btn btn-info">
                                                      <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                  </a>
                                                  <button class="btn btn-danger" type="button" onclick="deleteItem({{ $supplier->id }})">
                                                      <i class="fa fa-trash" aria-hidden="true"></i>
                                                  </button>
                                                  <form id="delete-form-{{ $supplier->id }}" action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="post"
                                                        style="display:none;">
                                                      @csrf
                                                      @method('DELETE')
                                                  </form>
                                              </td>
                                          </tr>
                                      @endforeach -->
                                    </tbody>

                                </table>
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
    </div> <!-- Content Wrapper end -->
@endsection




@push('js')

    <!-- DataTables -->
    <script src="{{ asset('assets/backend/plugins/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('assets/backend/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('assets/backend/plugins/fastclick/fastclick.js') }}"></script>

    <!-- Sweet Alert Js -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.1/dist/sweetalert2.all.min.js"></script>


    <script>
    $(document).ready(function(){
        var table = $('#example1').DataTable({

            processing: true,
            serverSide: true,
            method: "post",
            "searching": true,
            "paging": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,

            ajax: {
                'url' : '{{ route("admin.supplier.datatable")}}',

                //
                // success: function(data) {
                //   // swal( JSON.stringify(data));
                //      alert( JSON.stringify(data));
                //   //var mdata = '{"draw":1,"recordsTotal":1,"recordsFiltered":1,"data":[{"id":1,"name":"Product 1","category_id":1,"supplier_id":1,"code":"1232141","garage":"A","route":"A","image":"1232141.png","buying_date":"2022-01-01 00:00:00","expire_date":"2222-09-12 00:00:00","buying_price":1000,"selling_price":1500,"created_at":"2022-06-02 17:03:19","updated_at":"2022-06-02 20:58:54","category":"category 1","supplier":"Supplier 1"}]}';
                //   //return mdata;
                //   // swal( JSON.stringify(mdata));
                //   //return JSON.stringify(data);
                // },
                // error: function(xhr, status, error) {
                //   var err = eval("(" + xhr.responseText + ")");
                //   alert(xhr.responseText +status + error);
                // }
            },
            columns: [
                {data: 'id', width:"8%" , className :"text-left"},
                {data:   'name', width:"20%", className :"text-left"},
                {data:  'shop_name', width:"18%", className :"text-left"},
                {data:  'type', width:"5%", className :"text-left"},
                {data:   'phone', width:"15%", className :"text-left"},
                {data:   'email', width:"15%", className :"text-left"},
                {data:   'city', width:"10%", className :"text-left"},
                {data:   'actions', width:"20%", className :"text-right"}

            ],


        });




        table.columns().every(function () {



            var that = this;
            $('input', this.footer()).on( 'keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });
    });


    </script>


    <script type="text/javascript">
    function confirmDelete(e){
      var text = e.getAttribute('data-href');
      const swalWithBootstrapButtons = swal.mixin({
          confirmButtonClass: 'btn btn-success',
          cancelButtonClass: 'btn btn-danger',
          buttonsStyling: false,
      })
      swalWithBootstrapButtons({
          title: 'Are you sure to delete?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
      }).then((result) =>
      {
          if (result.value) {
              window.location.replace(text);
          } else if (

              result.dismiss === swal.DismissReason.cancel
          ) {
              swalWithBootstrapButtons(
                  'Cancelled',
                  'Your data is safe :)',
                  'error'
              )
          }
      })
    }


        function deleteItem(id) {
            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                    document.getElementById('delete-form-'+id).submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                        'Cancelled',
                        'Your data is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>



@endpush
