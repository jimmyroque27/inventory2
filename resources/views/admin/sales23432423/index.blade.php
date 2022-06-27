@extends('layouts.backend.app')

@section('title', 'Purchases')
@section('maintitle', 'Dashboard')
@section('mainUrl',route("admin.dashboard") )

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.css') }}">
    <!-- /* Chrome, Safari, Edge, Opera */ -->
    <style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
      padding:0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    input[type=number] {
      margin: 0;
      padding:0;

    }
    </style>
@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">



                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">List of Purchases

                                <?php
                                  $addBtn = route('admin.purchase.create');
                                  $BtnCaption = "New Purchase Order";
                                ?>
                                @include('includes._datatable_actions')

                                </h3>
                             </div>
                              <!-- /.card-header -->



                            <div class="card-body">


                                <table  id="example1" width="100%" class="table table-bordered table-striped text-center dataTable table-responsive-xl">
                                    <thead>
                                      <tr>
                                          <th width="10%">Tran. Id</th>
                                          <th width="30%">Supplier</th>
                                          <th width="15%">Reference No.</th>
                                          <th width="10%">Date</th>
                                          <th width="10%">Due Date</th>
                                          <th width="10%">Amount</th>

                                          <th width="15%">Action</th>
                                      </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>

                            </div>
                            <!-- /.card-body -->
                        </div>



                    </div>
                    <!--/.col (left) -->
                    <!-- .col (right) -->


                    <!--/.col (right) -->

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

        $(document).ready(function(){

        });
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

                processing: true,
                serverSide: true,
                method: "post",
                "searching": true,
                "paging": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,

                ajax: {
                    'url' : '{{ route("admin.purchase.datatable")}}',
                    //
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
                    {data: 'id', width:"12%" , className :"text-left"},
                    {data: 'supplier', width:"35.2%", className :"text-left"},
                    {data: 'refno', width:"14%", className :"text-left"},
                    {data: 'purchase_date', width:"10%", className :"text-left"},
                    {data: 'due_date', width:"10%", className :"text-left"},
                    {data: 'total', width:"10%", className :"text-right"},
                    {data: 'actions', width:"100%", className :"text-leftL actionsCol"},


                ],
                columnDefs: [
                  {
                    targets:5,
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
