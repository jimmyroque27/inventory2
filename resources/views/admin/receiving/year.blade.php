@extends('layouts.backend.app')

@section('title', 'Yearly Total Purchases')
@section('maintitle', 'Dashboard')
@section('mainUrl',route("admin.dashboard") )

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables/buttons.dataTables.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <?php
            $getYir = "Purchases Report";

          ?>
          @include('includes._datatable_actions')


        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->


                        <div class="card">
                            <div class="card-header row">
                                <div class="col-sm-6 ">
                                  <h3 class="card-title">
                                      <strong class="text-danger show-month">{{date('Y',strtotime($today))}}</strong> SALES LISTS

                                  </h3>
                                </div>
                                <div class="col-sm-6 ">
                                  <a href="#" id = "repDetailed" class="btn btn-primary float-right btn-sm">
                                    <i class="fa fa-list-alt nav-icon"></i> Detailed

                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                              <table id="example1" class="table table-bordered table-striped text-center">

                                  <thead>
                                  <tr>
                                      <th>ID No.</th>
                                      <th>Supplier Name</th>
                                      <th>R.R. No.</th>
                                      <th>Purchase Date</th>

                                      <th>Status</th>
                                      <th>Total</th>
                                      <th>Payment</th>
                                      <th>Balance</th>
                                  </tr>
                                  </thead>
                                  <tfoot>
                                  <tr>
                                      <td  ></td>
                                      <td  ></td>
                                      <td  ></td>
                                      <td  ></td>
                                      <td   class="text-right">Total</td>

                                      <td class="text-right"></td>
                                      <td class="text-right"></td>
                                      <td class="text-right"></td>
                                  </tr>
                                </tfoot>
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
    <script src="{{ asset('assets/backend/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/datatables/buttons.print.min.js') }}"></script>

    <script src="{{ asset('assets/backend/plugins/datatables/buttons.colVis.min.js') }}"></script>


    <script>
        var month;
        var table;
        $(document).ready(function(){

            urlAjax = "{{url('/') . '/admin/receiving/today/'}}";
            var d = new Date();
            var strDate =  (d.getMonth()+1) + "/" + d.getDate() + "/" + d.getFullYear();
             table = $('#example1').DataTable({
                processing: true,
                serverSide: true,
                select: true,
                dom: 'lBfrtp',
                pageLength: 50,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, 'All'],
                ],
                buttons: [
                  {
                      "extend": "colvis",
                      "text": "<i class='fa fa-eye text-125  text-dark-m2'></i> <span class='d-none'>Show/hide columns</span>",
                      "className": "btn-sm btn-outline-info bg-dark btn-h-outline-primary btn-a-outline-primary",
                      columns: ':not(:first)'
                  },
                  {
                      "extend": "copy", footer: true ,
                      title: '',
                      "text": "<i class='far fa-copy text-125 text-purple'></i> <span class='d-none'>Copy to clipboard</span>",
                      "className": "btn-sm btn-outline-info bg-info btn-h-outline-primary btn-a-outline-primary",
                      message: function() { return $(".show-month").html() +" SALES REPORT" }
                  },
                  {
                      "extend": "csv", footer: true ,
                      title: '',
                      "text": "<i class='fa fa-file-text-o text-125 text-success-m2'></i> <span class='d-none'>Export to CSV</span>",
                      "className": "btn-sm btn-outline-info bg-primary btn-h-outline-primary btn-a-outline-primary",
                      message: function() { return $(".show-month").html() +" SALES REPORT" }
                  },
                  {
                      "extend": "excel", footer: true ,
                      title: '',
                      "text": "<i class='fa fa-file-excel-o text-125 text-success-m2'></i> <span class='d-none'>Export to CSV</span>",
                      "className": "btn-sm btn-outline-info bg-success  btn-h-outline-primary btn-a-outline-primary",
                      message: function() { return $(".show-month").html() +" SALES REPORT" }
                  },
                  {
                      "extend": "pdf", footer: true ,
                      title: '',
                      "text": "<i class='fa fa-file-pdf-o  text-125 text-success-m2'></i> <span class='d-none'>Export to PDF</span>",
                      "className": "btn-sm btn-outline-info bg-danger btn-h-outline-primary btn-a-outline-primary",
                      message: function() { return $(".show-month").html() +" SALES REPORT" }
                  },
                  {
                      "extend": "print", footer: true ,
                      title: '',
                      "text": "<i class='fa fa-print text-125 text-orange-d1'></i> <span class='d-none'>Print</span>",
                      "className": "btn-sm btn-outline-info bg-secondary tn-h-outline-primary",
                      autoPrint: true,
                      message: function() { return '<h4> <span class="text-danger">'+  $(".show-month").html() +"</span> SALES REPORT" + "</h4>" }
                  }
                ],

                pageLength: 100,


                method: "post",
                ajax: {
                    "data" : {
                        "dateyear"  : function() { return $("#yearto").val() }
                    },
                    'url' : '{{ route("admin.order.datatableyear")}}',


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
                    {data: 'invoiceno', width:"14%", className :"text-left"},
                    {data: 'purchase_date', width:"10%", className :"text-left"},

                    {data: 'purchase_status', width:"10%", className :"text-left"},
                    {data: 'total', width:"10%", className :"text-right"},
                    {data: 'pay', width:"10%", className :"text-right"},
                    {data: 'balance', width:"10%", className :"text-right"},
                    // {data: 'actions', width:"100%", className :"text-leftL actionsCol"},


                ],
                columnDefs: [
                  {
                    targets:5,
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                  },
                  {
                    targets:6,
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                  },

                  {
                    targets:7,
                    render: $.fn.dataTable.render.number(',', '.', 2, '')
                  },

                ],
                footerCallback: function (row, data, start, end, display) {
                  var api = this.api();
                  apiFooter(api,5);
                  apiFooter(api,6);
                  apiFooter(api,7);
                },
            });

            function apiFooter(api, col){


              // Remove the formatting to get integer data for summation
              var intVal = function (i) {
                  return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
              };

              // Total over all pages
              total = api.column(col).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
              }, 0);

              // Total over this page
              pageTotal = api.column(col, { page: 'current' }).data().reduce(function (a, b) {
                      return intVal(a) + intVal(b);
              }, 0);

              // Update footer
              // $(api.column(col).footer()).html(pageTotal.toLocaleString("en") + ' <br>' + total.toLocaleString("en") );
              $(api.column(col).footer()).html(  total.toLocaleString("en") );

            }


            table.columns().every(function () {



                var that = this;
                $('input', this.footer()).on( 'keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });


            // $("#btn-reload").click(function(){
            //
            // });
            $("#repDetailed").click(function(){
              $("#repDetailed").attr("href", urlAjax = "{{url('/') . '/admin/receiving-total/detailed/'}}"+$("#dateto").val())
            });


        });
        function reloadDatatable(){

          table.ajax.reload();

          // $(".today-span").html($("#dateto").val());


        }

        function ajaxReload(month){

          $(".show-month").html($("#yearto").val());
          $("#datefrom").val($("#yearto").val()+'-01-01')
          $("#dateto").val($("#yearto").val()+'-12-31')
          reloadDatatable();
        }

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



@endpush
