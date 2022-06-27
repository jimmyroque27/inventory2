@extends('layouts.backend.app')

@section('title', 'Receipt Details')
@section('maintitle', 'Receipts')
@section('mainUrl',route("admin.receipt.index") )

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/bootstrap-select.min.css')}}"/>
    <!-- <link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/ajax-bootstrap-select.css')}}"> -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/adminlte.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/adjust-select.css')}}"/>
@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

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
                            <div class="card-header bg-dark">
                                <h3 class="card-title">Receipt Transaction

                                  <a href="{{ route('admin.receipt.create') }}" class="btn bg-dark  float-md-right"><i class="fa fa-plus-circle nav-icon"> </i> &nbsp; <span> New Receipt</span></a>
                                  @if($receiptheader->finalized == 0)
                                    <a href="{{ route('admin.receipt.finalized',$receiptheader->id) }}" onclick="finalizeConfirm()" class="btn bg-dark  float-md-right"><i class="fa fa-key nav-icon"> </i> &nbsp; <span> Finalize</span></a>
                                  @endif
                                  <a href="{{ route('admin.receipt.print',$receiptheader->id) }}" target="_blank" class="btn bg-dark  float-md-right">
                                      <i class="fa fa-print"></i> Print
                                  </a>
                                </h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label   for="customer_id">Customer Name: </label>
                                                {{ $receiptheader->customer->name}}

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>O.R. ID: </label>
                                                {{ $receiptheader->id}}

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>O.R. No. :</label>
                                                {{ $receiptheader->orno}}

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                          <div class="form-group">
                                              <label  >Date: </label>
                                              {{ $receiptheader->receipt_date}}
                                          </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="card">
                                          <div class="card-header bg-secondary ">
                                            <label>Payment Details</label>
                                          </div>
                                          <div class="card-body">
                                             <table id="table1" width="100%" class="table table-bordered table-striped text-center table-responsive-xl">
                                              <thead>
                                              <tr>
                                                  <th width="25%" class="align-middle">Payment Method</th>

                                                  <th width="10%" class="align-middle">Amount</th>
                                                  @if($receiptheader->finalized == 0)
                                                    <th width="15%" class="align-middle">Actions</th>
                                                  @endif
                                              </tr>
                                              </thead>

                                              <tbody>

                                              </tbody>
                                              <tfoot>
                                                <tr>

                                                    <td colspan="1" width="10%">TOTAL</td>
                                                    <td width="10%">{{ number_format($receiptheader->paid_detail,2) }}</td>
                                                    @if($receiptheader->finalized == 0)
                                                      <td width="15%"></td>
                                                    @endif

                                                </tr>

                                              </tfoot>

                                            </table>
                                            <a href="#" onclick="document.getElementById('modalPayDetails').style.display='block'"  id="btnAddPayDetails"  class="btn btn-primary offset-sm-1 float-md-right">
                                              <span>Add Payment Details</span>
                                            </a>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-6">

                                        <div class="card">
                                          <div class="card-header bg-secondary ">
                                            <label>Payment Orders</label>
                                          </div>
                                          <div class="card-body">
                                            <table id="table2" width="100%" class="table table-bordered table-striped text-center table-responsive-xl">
                                                <thead>
                                                <tr>
                                                    <th width="25%" class="align-middle">Order Id</th>
                                                    <th width="25%" class="align-middle">Invoice No.</th>
                                                    <th width="10%" class="align-middle">Amount</th>
                                                    <th width="10%" class="align-middle">Discounting</th>
                                                    @if($receiptheader->finalized == 0)
                                                      <th width="15%" class="align-middle">Actions</th>
                                                    @endif
                                                </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                  <tr>

                                                      <td colspan="2" width="10%">TOTAL</td>
                                                      <td width="10%">{{ number_format($receiptheader->paid_invoice,2) }}</td>
                                                      <td width="15%">{{ number_format($receiptheader->discount,2) }}</td>
                                                      @if($receiptheader->finalized == 0)
                                                        <td width="15%"></td>
                                                      @endif

                                                  </tr>

                                                </tfoot>

                                            </table>
                                            <div class="row">
                                              <div class="col-md-8">
                                                @if($receiptheader->paid_invoice != $receiptheader->paid_detail)
                                                  <div class="card bg-danger col-sm-12">
                                                    There is a Discrepancy in Payment Invoice/Details Amount<br>
                                                    Difference: {{  $receiptheader->paid_detail - $receiptheader->paid_invoice }}

                                                  </div>
                                                @endif
                                              </div>
                                              <div class="col-md-4">
                                                <a href="#" onclick="document.getElementById('modalPayInvoice').style.display='block'"  id="btnAddPayInvoice" class="btn btn-primary offset-sm-1 float-md-right">
                                                  <span>Add Payment Invoice</span>
                                                </a>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Notes: </label>
                                            {{ $receiptheader->notes}}
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



            <form action="#" method="post" id="formPayDetails">
                @csrf
                <div class="modal" id="modalPayDetails" >
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalPayDetailsLabel">
                                    Payment Details
                                </h5>
                                <span onclick="document.getElementById('modalPayDetails').style.display='none'" class="close" title="Close Modal">&times;</span>
                            </div>
                            <div class="modal-body">

                                <div class="form-row">
                                    <div class="form-group col-md-6">

                                        <label>Payment Method</label>
                                        <input hidden type="text" id="payment_status" name="payment_status" class="form-control"  value="Cash">
                                        <select id="paytype_id" name="paytype_id" class="form-control Cash" required>
                                            <!-- <option value="" disabled selected>Select a Payment Method</option> -->
                                            @foreach($paymenttypes as $paymenttype)
                                                <option value="{{ $paymenttype->id }}" {{ ($paymenttype->id== 1) ? 'selected':''}}>{{ $paymenttype->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="inputPay">Pay</label>
                                        <input type="number" name="payment" id="payment" class="form-control" max=" " value="">
                                    </div>
                                </div>
                                <div class="form-row d-none Pay-Details">
                                  <div class="form-group col-md-6">
                                      <label for="inputmerchant_id" >Bank/Merchant</label>
                                      <select name="merchant_id" id="merchant_id"  class="form-control Cash"  >
                                          <option value="" disabled selected>Select a Bank/Merchant</option>
                                          @foreach($merchants as $merchant)
                                              <option value="{{ $merchant->id }}"  >{{ $merchant->name }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="inputrefname" class='input-refname'>Name</label>
                                      <input type="text" name="refname" id="refname" class="form-control" >
                                  </div>

                                </div>
                                <div class="form-row  d-none Pay-Details">
                                  <div class="form-group col-md-6">
                                      <label for="inputrefno" class='input-refno'>No.</label>
                                      <input type="text" name="refno"  id="refno"  class="form-control">
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="inputrefdate" class='input-refdate'>Date</label>
                                      <input type="date" name="refdate" id="refdate" class="form-control" >
                                  </div>
                                </div>
                                <div class="form-row  d-none Pay-Details2">
                                  <div class="form-group col-md-6">
                                      <label for="inputrefname" class='input-approval_id'>Approval No.</label>
                                      <input type="text" name="approval_id"  id="approval_id" class="form-control">
                                  </div>
                                  <div class="form-group col-md-6">
                                      <label for="inputrefdate" class='input-approval_date'>Approval Date</label>
                                      <input type="date" name="approval_date" id="approval_date" class="form-control" >
                                  </div>
                                </div>
                            </div>
                            <input type="hidden" name="receipt_id"  id="receipt_id" value="{{ $receiptheader->id}}">
                            <input type="hidden" id="paydetail_id" name="paydetail_id" value="">
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Save</button>
                              <span onclick="document.getElementById('modalPayDetails').style.display='none'" class="btn btn-dark" title="Close Modal">{{ __('Close') }}</span>

                            </div>
                        </div>
                    </div>
                </div>
            </form>



            <form action="#" method="post" id="formPayInvoice">
                @csrf
                <div class="modal" id="modalPayInvoice" >
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalPayInvoiceLabel">
                                    Payment Invoice
                                </h5>
                                <span onclick="document.getElementById('modalPayInvoice').style.display='none'" class="close" title="Close Modal">&times;</span>
                            </div>
                            <div class="modal-body">

                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-8">
                                       <div class="form-group  ">
                                              <label   for="order_id">Order ID</label>
                                              <input readonly type="text" id="order_id2" name="order_id2" class="form-control d-none"  value="">

                                              <select required id="order_id" name="order_id" class="selectpicker ajax-order_id w-100" data-live-search="true"></select>
                                      </div>
                                      <div class="form-group ">
                                          <label for="inputPay">Amount Paid</label>
                                          <input type="number" name="paid_invoice" id="paid_invoice" class="form-control" max=" " value="0">
                                      </div>
                                      <div class="form-group ">
                                          <label for="inputPay">Discounting</label>
                                          <input type="number" name="discount" id="discount" class="form-control" max=" " value="0">
                                      </div>
                                    </div>

                                    <div class="col-sm-2">
                                    </div>


                            </div>

                            <input type="hidden" id="payinvoice_id" name="payinvoice_id" value="">
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Save</button>
                              <span onclick="document.getElementById('modalPayInvoice').style.display='none'" class="btn btn-dark" title="Close Modal">{{ __('Close') }}</span>

                            </div>
                        </div>
                    </div>
                </div>
            </form>

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
        <script src="{{ asset('assets/backend/bootstrap-select/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('assets/backend/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/backend/bootstrap-select/js/ajax-bootstrap-select.js')}}"></script>
        <script>
            var select_orders = {
                ajax          : {
                    url     : "{{ route('admin.order.dropdownselect',$receiptheader->customer_id)}}",
                    type    : 'get',

                    dataType: 'json',

                    // success: function(data) {
                    //   // swal( JSON.stringify(data));
                    //      alert( JSON.stringify(data));
                    //   //var mdata = '{"draw":1,"recordsTotal":1,"recordsFiltered":1,"data":[{"id":1,"name":"Product 1","category_id":1,"customer_id":1,"code":"1232141","garage":"A","route":"A","image":"1232141.png","buying_date":"2022-01-01 00:00:00","expire_date":"2222-09-12 00:00:00","buying_price":1000,"selling_price":1500,"created_at":"2022-06-02 17:03:19","updated_at":"2022-06-02 20:58:54","category":"category 1","customer":"Customer 1"}]}';
                    //   //return mdata;
                    //   // swal( JSON.stringify(mdata));
                    //   //return JSON.stringify(data);
                    // },
                    // error: function(xhr, status, error) {
                    //   var err = eval("(" + xhr.responseText + ")");
                    //   alert(xhr.responseText +status + error);
                    // }


                },
                locale        : {
                    emptyTitle: 'Select and Begin Typing'
                },
                preserveSelected: false,
                clearOnEmpty: true,
                cache: false,
                emptyRequest: true,
                // log           : 3,
                preprocessData: function (data) {
                    var i, l = data.length, array = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            array.push($.extend(true, data[i], {
                                text : data[i].id,
                                value: data[i].id,
                                data : {
                                     subtext: data[i].invoiceno + " | " + data[i].order_date + " | " + data[i].order_status +" | Balance: " + data[i].balance.toLocaleString()
                                }
                            }));
                        }
                    }
                    // You must always return a valid array when processing data. The
                    // data argument passed is a clone and cannot be modified directly.
                    return array;
                }
            };

            $('.selectpicker').selectpicker().filter('.ajax-order_id').ajaxSelectPicker(select_orders);
            $('select').trigger('change');
        </script>
        <script>
            $(document).ready(function(){
                var finaldisplay =" d-none ";
                @if($receiptheader->finalized == 0)
                  finaldisplay =" ";
                @endif
                var table = $('#table1').DataTable({
                    serverSide: true,
                    method: "post",
                    "searching": false,
                    "paging": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,

                    ajax: {
                        'url' : '{{ route("admin.receipt.detailsdatatable","$receiptheader->id")}}',
                        // success: function(data) {
                        //      alert( JSON.stringify(data));
                        //   // swal( JSON.stringify(data));
                        // },
                        // error: function(xhr, status, error) {
                        //   var err = eval("(" + xhr.responseText + ")");
                        //   swal(xhr.responseText +status + error);
                        // }
                    },
                    columns: [
                        {data: 'paytype', width:"32%" , className :"text-left"},
                        {data: 'amount', width:"8%", className :"text-right"},
                        {data: 'actions', width:"10%", className :"text-left actionsCol"+finaldisplay},
                        {data: 'paytype_id', width:"0%", className:"d-none"},
                        {data: 'merchant_id', width:"0%", className:"d-none"},
                        {data: 'refno', width:"0%", className:"d-none"},
                        {data: 'refname', width:"0%", className:"d-none"},
                        {data: 'refdate', width:"0%", className:"d-none"},
                        {data: 'approval_id', width:"0%", className:"d-none"},
                        {data: 'approval_date', width:"0%", className:"d-none"},

                    ],
                    columnDefs: [
                      {
                        targets:1, render: $.fn.dataTable.render.number(',', '.', 0, '')
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

                var table2 = $('#table2').DataTable({
                    serverSide: true,
                    method: "post",
                    "searching": false,
                    "paging": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,

                    ajax: {
                        'url' : '{{ route("admin.receipt.invoicedatatable","$receiptheader->id")}}',
                        // success: function(data) {
                        //      alert( JSON.stringify(data));
                        //   // swal( JSON.stringify(data));
                        // },
                        // error: function(xhr, status, error) {
                        //   var err = eval("(" + xhr.responseText + ")");
                        //   swal(xhr.responseText +status + error);
                        // }
                    },
                    columns: [
                        {data: 'order_id', width:"20%" , className :"text-left"},
                        {data: 'invoiceno', width:"20%" , className :"text-left"},
                        {data: 'amount', width:"20%", className :"text-right"},
                        {data: 'discount', width:"20%", className :"text-right"},
                        @if($receiptheader->finalized == 0)
                          {data: 'actions', width:"20%", className :"text-leftL actionsCol"},
                        @endif

                    ],
                    columnDefs: [
                      {
                       targets:2,

                       render: $.fn.dataTable.render.number(',', '.', 0, '')
                      },
                      {
                       targets:3,
                       render: $.fn.dataTable.render.number(',', '.', 2, '')
                      },
                    ],

                });
                table2.columns().every(function () {



                    var that = this;
                    $('input', this.footer()).on( 'keyup change', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });


            });
        </script>
        <script>
          // Get the modal
         var modalPayDetails = document.getElementById('modalPayDetails');
         var modalPayInvoice = document.getElementById('modalPayInvoice');

          $("#btnAddPayDetails").click(function(){

            $("#formPayDetails").attr('action',"{{ route('admin.receipt.storedetail',$receiptheader->id) }}");
          });
          $("#btnAddPayInvoice").click(function(){
            $("#order_id").prop('required',true);
            $(".ajax-order_id").show();

            $("#order_id2").addClass("d-none");
            $("#formPayInvoice").attr('action',"{{ route('admin.receipt.storeinvoice',$receiptheader->id) }}");
          });

        </script>

        <!-- Select Options from ajax URL -->

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

          function finalizeConfirm(){
                const swalWithBootstrapButtons = swal.mixin({
                    confirmButtonClass: 'btn btn-success',
                    cancelButtonClass: 'btn btn-danger',
                    buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                    title: 'Are you sure to finalize this transaction?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Finalize it!',
                    cancelButtonText: 'No, Cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                      return true;
                    } else {
                        // Read more about handling dismissals
                        return false;
                    }
                })


          }

          function showEditForm(e){
            // document.getElementById('modalPayDetails')
            modalPayDetails.style.display='block';
              $("#formPayDetails").attr('action',"{{ route('admin.receipt.detail.update') }}");
              // alert(e)
             $("#paydetail_id").val(e);
             paytype_id = $("#table1 #row_"+e+" td:nth-child(4)").text();
             merchant_id = $("#table1 #row_"+e+" td:nth-child(5)").text();
             refno = $("#table1 #row_"+e+" td:nth-child(6)").text();
             refname = $("#table1 #row_"+e+" td:nth-child(7)").text();
             refdate = $("#table1 #row_"+e+" td:nth-child(8)").text();
             approval_id = $("#table1 #row_"+e+" td:nth-child(9)").text();
             approval_date = $("#table1 #row_"+e+" td:nth-child(10)").text();
             payment = $("#table1 #row_"+e+" td:nth-child(2)").text();
             $("#payment").val(payment.replace(",",""));
             $("#paytype_id").val(paytype_id).change();
             $("#merchant_id").val(merchant_id).change();
             $("#refno").val(refno);
             $("#refname").val(refname);
             $("#refdate").val(refdate);
             $("#approval_id").val(approval_id);
             $("#approval_date").val(approval_date);


          }

          function showEditForm2(e){
            // document.getElementById('modalPayDetails')

            $("#order_id2").removeClass("d-none");
            $("#order_id").prop('required',false);
            $(".ajax-order_id").hide();

            modalPayInvoice.style.display='block';
              $("#formPayInvoice").attr('action',"{{ route('admin.receipt.invoice.update',$receiptheader->id) }}");
              // alert("{{$receiptheader->id}}")
             $("#payinvoice_id").val(e);
             order_id = $("#table2 #row_inv_"+e+" td:first").text();
             // $("#order_id").val(order_id).change();
             $("#order_id2").val(order_id);

             paid_invoice = $("#table2 #row_inv_"+e+" td:nth-child(3)").text();
             discount = $("#table2 #row_inv_"+e+" td:nth-child(4)").text();
             // alert(paid_invoice)
             $("#paid_invoice").val(paid_invoice.replace(",",""));
             $("#discount").val(discount.replace(",",""));
             $("#paid_invoice").focus();


          }
        </script>

        <script>
          $( document ).ready(function() {
            $("#paytype_id").change(function(){
              // alert("sdfsdf");
              var paymenttype = $("#paytype_id").find(":selected").text();
              // alert(paymenttype);
              $("#payment_status").val(paymenttype);
              // alert($("#payment_status").val());
              if (($("#paytype_id").val() != "1") &&  ($("#paytype_id").val() != "7" )  ){
                $(".Pay-Details").removeClass("d-none");
                $(".Pay-Details2").removeClass("d-none");
                $(".input-refno").html(paymenttype + " No.");
                $(".input-refname").html(paymenttype + " Name");
                $(".input-refdate").html(paymenttype + " Date");
                if ($("#paytype_id").val() != "2"){
                 $(".input-approval_id").html(paymenttype + " Approval No.");
                 $(".input-approval_date").html(paymenttype + " Approval Date");
                }else{$(".Pay-Details2").addClass("d-none")}
              }else{
                $(".Pay-Details").addClass("d-none")
                $(".Pay-Details2").addClass("d-none")
              }

            });


          });

        </script>
@endpush
