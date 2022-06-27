@extends('layouts.backend.app')

@section('title', 'Products')
@section('maintitle', 'Products')
@section('mainUrl',route("admin.product.index") )

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/adjust-select.css')}}"/>
@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <!-- <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 offset-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Products </li>
                        </ol>
                    </div>
                </div>
            </div>

        </section> -->
        <br>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">PRODUCTS LISTS
                                  <?php
                                    $addBtn = route('admin.product.create');
                                    $BtnCaption = "Add Products";
                                  ?>
                                  @include('includes._datatable_actions')
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped text-center table-responsive-xl">
                                    <thead>
                                    <tr>

                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Image</th>
                                        <th>Category</th>
                                        <!-- <th>Supplier</th> -->

                                        <th>Garage</th>
                                        <th>Route</th>

                                        <!-- <th>Buy Price</th> -->
                                        <th>Sell Price</th>
                                        <th>Qty</th>

                                          <th>Actions</th>

                                    </tr>
                                    </thead>

                                    <tbody>

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
        $(function () {
            $("#exampless1").DataTable();
            $('#exampless2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });
    </script>


    <script type="text/javascript">
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

    <script>


        $(document).ready(function(){
            var table = $('#example1').DataTable({

                serverSide: true,
                method: "post",
                "searching": true,
                "paging": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,

                ajax: {
                    'url' : '{{ route("admin.product.datatable")}}',

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
                    {data: 'aname', width:"27%" , className :"text-left"},
                    {data:   'acode', width:"10%", className :"text-left"},
                    {data:  'aimage', width:"10%", className :"text-left"},
                    {data:  'acategory', width:"15%", className :"text-left"},
                    {data:   'garage', width:"5%", className :"text-left"},
                    {data:   'route', width:"5%", className :"text-left"},

                    {data:   'selling_price', width:"10%", className :"text-right"},
                    {data:   'onhand', width:"10%", className :"text-right"},
                    {data:   'actions', width:"15%", className :"text-right"}

                ],
                columnDefs: [
                  {
                    targets:6,
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                  },
                  {
                    targets:7,
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                  },

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



@endpush
