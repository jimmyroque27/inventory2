@extends('layouts.backend.app')

@section('title', 'Show Product')
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
        <section class="content-header">
            <!-- <div class="container-fluid">


                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Product Details</li>
                        </ol>


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
                                <h3 class="card-title">Product Details
                                  <?php
                                    $addBtn = route('admin.product.create');
                                    $BtnCaption = "Add Products";
                                  ?>
                                  @include('includes._datatable_actions')

                                  <?php
                                    $addBtn = route('admin.product.variant.create', $product->id );
                                    $BtnCaption = "Add Variant";
                                  ?>
                                  @include('includes._datatable_actions')
                                </h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->


                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-2">
                                          <label>Name</label>
                                        </div>
                                        <div class="col-md-4">
                                          {{ $product->name }}
                                        </div>
                                        <div class="col-md-2">
                                          <label>Code</label>
                                        </div>
                                        <div class="col-md-4">
                                          {{ $product->code }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                          <label>Picture</label>
                                        </div>
                                        <div class="col-md-4">
                                          <p>
                                              <img width="50" height="50" src="{{ URL::asset("product/".$product->image) }}" alt="{{ $product->name }}">
                                          </p>
                                        </div>
                                        <div class="col-md-2">
                                          <div class="form-group">
                                              <label>Garage</label>
                                              <p>{{ $product->garage }}</p>
                                          </div>
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                              <label>Route</label>
                                              <p>{{ $product->route }}</p>
                                          </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-2">
                                          <label>Category</label>
                                        </div>
                                        <div class="col-md-4">
                                            {{ $product->category->name }}
                                        </div>
                                        <div class="col-md-2">
                                          <label>Supplier</label>
                                        </div>
                                        <div class="col-md-4">
                                          {{ $product->supplier->name }}
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-2">
                                          <label>Starting Date</label>
                                        </div>
                                        <div class="col-md-4">
                                          {{ $product->buying_date->toFormattedDateString() }}
                                        </div>
                                        <div class="col-md-2">
                                          <label>Expire Date</label>
                                        </div>
                                        <div class="col-md-4">
                                          {{ $product->expire_date->toFormattedDateString() }}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                          <label>Purchase Price</label>
                                        </div>
                                        <div class="col-md-4">
                                            {{ number_format($product->buying_price, 2)  }}
                                        </div>
                                        <div class="col-md-2">
                                          <label>Selling Price</label>
                                        </div>
                                        <div class="col-md-4">
                                          {{ number_format($product->selling_price, 2)   }}
                                        </div>
                                    </div>
                                    <table id="example1" width = "100%" class="table table-bordered table-striped text-center table-responsive ">
                                        <thead>
                                        <tr>

                                            <th width="30%">Variant</th>
                                            <th width="15%">Color</th>
                                            <th width="15%">Size</th>

                                            <th width="10%">Buy Price</th>
                                            <th width="10%">Sell Price</th>
                                            <th width="10%">Qty</th>

                                            <th width="40%">Actions</th>

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
    </div>
    <!-- /.content-wrapper -->
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
          // alert('{{ route("admin.product.variantdatatable", $product->id ) }}');
            var table = $('#example1').DataTable({
                processing: true,
                serverSide: true,
                method: "post",
                "searching": false,
                "paging": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "width": "100%",

                ajax: {
                    'url' : '{{ route("admin.product.variantdatatable", $product->id ) }}',


                    // success: function(data) {
                    //   // swal( JSON.stringify(data));
                    //
                    //      alert( JSON.stringify(data));
                    //   //var mdata = '{"draw":1,"recordsTotal":1,"recordsFiltered":1,"data":[{"id":1,"name":"Product 1","category_id":1,"supplier_id":1,"code":"1232141","garage":"A","route":"A","image":"1232141.png","buying_date":"2022-01-01 00:00:00","expire_date":"2222-09-12 00:00:00","buying_price":1000,"selling_price":1500,"created_at":"2022-06-02 17:03:19","updated_at":"2022-06-02 20:58:54","category":"category 1","supplier":"Supplier 1"}]}';
                    //   //return mdata;
                    //   // swal( JSON.stringify(mdata));
                    //   //return JSON.stringify(data);
                    // },
                    // error: function(xhr, status, error) {
                    //
                    //   var err = eval("(" + xhr.responseText + ")");
                    //   alert(xhr.responseText +status + error);
                    // }
                },
                columns: [
                    {data: 'variant', width:"30%" , className :"text-left"},
                    {data:   'color', width:"17%" , className :"text-left"},
                    {data:  'size', width:"17%" , className :"text-left"},
                    {data:   'buying_price', width:"10%" , className :"text-right"},
                    {data:   'selling_price', width:"10%" , className :"text-right"},
                    {data:   'onhand', width:"8.5%" , className :"text-right"},
                    {data:   'actions',  width:"20%" , className :"text-left"}
                ],
                columnDefs: [


                  {
                    targets:3,

                    render: $.fn.dataTable.render.number(',', '.', 2, '')

                  },
                  {
                    targets:4,

                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                  },
                  {
                    targets:5,

                    render: $.fn.dataTable.render.number(',', '.', 0, '')
                  }

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
    </script>

@endpush
