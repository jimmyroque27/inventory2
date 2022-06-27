@extends('layouts.backend.app')

@section('title', 'Purchase Payment')
@section('maintitle', 'Payments')
@section('mainUrl',route("admin.payment.index") )

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
                                <h3 class="card-title">Payment Transaction

                              

                                  <a href="{{ route('admin.payment.create') }}" class="btn bg-dark  float-md-right"><i class="fa fa-plus-circle nav-icon"> </i> &nbsp; <span> New Payment</span></a>
                                  @if($paymentheader->finalized == 0)
                                    <a href="{{ route('admin.payment.finalized',$paymentheader->id) }}" onclick="finalizeConfirm()" class="btn bg-dark  float-md-right"><i class="fa fa-key nav-icon"> </i> &nbsp; <span> Finalize</span></a>
                                  @endif
                                </h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label   for="supplier_id">Supplier Name: </label>
                                                {{ $paymentheader->supplier->name}}

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>O.R. ID: </label>
                                                {{ $paymentheader->id}}

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>O.R. No. :</label>
                                                {{ $paymentheader->orno}}

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                          <div class="form-group">
                                              <label  >Date: </label>
                                              {{ $paymentheader->payment_date}}
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
                                                  @if($paymentheader->finalized == 0)
                                                    <th width="15%" class="align-middle">Actions</th>
                                                  @endif
                                              </tr>
                                              </thead>

                                              <tbody>

                                              </tbody>
                                              <tfoot>
                                                <tr>

                                                    <td colspan="1" width="10%">TOTAL</td>
                                                    <td width="10%">{{ number_format($paymentheader->paid_detail,2) }}</td>
                                                    @if($paymentheader->finalized == 0)
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
                                            <label>Payment Purchases</label>
                                          </div>
                                          <div class="card-body">
                                            <table id="table2" width="100%" class="table table-bordered table-striped text-center table-responsive-xl">
                                                <thead>
                                                <tr>
                                                    <th width="25%" class="align-middle">Purchase Id</th>
                                                    <th width="25%" class="align-middle">Purchase No.</th>
                                                    <th width="10%" class="align-middle">Amount</th>
                                                    <th width="10%" class="align-middle">Discounting</th>
                                                    @if($paymentheader->finalized == 0)
                                                      <th width="15%" class="align-middle">Actions</th>
                                                    @endif
                                                </tr>
                                                </thead>

                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                  <tr>

                                                      <td colspan="2" width="10%">TOTAL</td>
                                                      <td width="10%">{{ number_format($paymentheader->paid_purchase,2) }}</td>
                                                      <td width="15%">{{ number_format($paymentheader->discount,2) }}</td>
                                                      @if($paymentheader->finalized == 0)
                                                        <td width="15%"></td>
                                                      @endif

                                                  </tr>

                                                </tfoot>

                                            </table>
                                            <div class="row">
                                              <div class="col-md-8">
                                                @if($paymentheader->paid_purchase != $paymentheader->paid_detail)
                                                  <div class="card bg-danger col-sm-12">
                                                    There is a Discrepancy in Payment Purchase/Details Amount<br>
                                                    Difference: {{  $paymentheader->paid_detail - $paymentheader->paid_purchase }}

                                                  </div>
                                                @endif
                                              </div>
                                              <div class="col-md-4">
                                                <a href="#" onclick="document.getElementById('modalPayPurchase').style.display='block'"  id="btnAddPayPurchase" class="btn btn-primary offset-sm-1 float-md-right">
                                                  <span>Add Payment Purchase</span>
                                                </a>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Notes: </label>
                                            {{ $paymentheader->notes}}
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
                            <input type="hidden" name="payment_id"  id="payment_id" value="{{ $paymentheader->id}}">
                            <input type="hidden" id="paydetail_id" name="paydetail_id" value="">
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Save</button>
                              <span onclick="document.getElementById('modalPayDetails').style.display='none'" class="btn btn-dark" title="Close Modal">{{ __('Close') }}</span>

                            </div>
                        </div>
                    </div>
                </div>
            </form>



            <form action="#" method="post" id="formPayPurchase">
                @csrf
                <div class="modal" id="modalPayPurchase" >
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalPayPurchaseLabel">
                                    Payment Purchase
                                </h5>
                                <span onclick="document.getElementById('modalPayPurchase').style.display='none'" class="close" title="Close Modal">&times;</span>
                            </div>
                            <div class="modal-body">

                                    <div class="col-sm-2">
                                    </div>
                                    <div class="col-sm-8">
                                       <div class="form-group  ">
                                              <label   for="purchase_id">Purchase ID</label>
                                              <input readonly type="text" id="purchase_id2" name="purchase_id2" class="form-control d-none"  value="">

                                              <select required id="purchase_id" name="purchase_id" class="selectpicker ajax-purchase_id w-100" data-live-search="true"></select>
                                      </div>
                                      <div class="form-group ">
                                          <label for="inputPay">Amount Paid</label>
                                          <input type="number" name="paid_purchase" id="paid_purchase" class="form-control" max=" " value="0">
                                      </div>
                                      <div class="form-group ">
                                          <label for="inputPay">Discounting</label>
                                          <input type="number" name="discount" id="discount" class="form-control" max=" " value="0">
                                      </div>
                                    </div>

                                    <div class="col-sm-2">
                                    </div>


                            </div>

                            <input type="hidden" id="paypurchase_id" name="paypurchase_id" value="">
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Save</button>
                              <span onclick="document.getElementById('modalPayPurchase').style.display='none'" class="btn btn-dark" title="Close Modal">{{ __('Close') }}</span>

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
            var select_purchases = {
                ajax          : {
                    url     : "{{ route('admin.purchase.dropdownselect',$paymentheader->supplier_id)}}",
                    type    : 'get',

                    dataType: 'json',

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
                                     subtext: data[i].purchaseno + " | Date: " + data[i].purchase_date + " | Due Date: " + data[i].puchase_duedate + " | Due: " + data[i].balance.toLocaleString()
                                }
                            }));
                        }
                    }
                    // You must always return a valid array when processing data. The
                    // data argument passed is a clone and cannot be modified directly.
                    return array;
                }
            };

            $('.selectpicker').selectpicker().filter('.ajax-purchase_id').ajaxSelectPicker(select_purchases);
            $('select').trigger('change');
        </script>
        <script>
            $(document).ready(function(){
                var finaldisplay =" d-none ";
                @if($paymentheader->finalized == 0)
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
                        'url' : '{{ route("admin.payment.detailsdatatable","$paymentheader->id")}}',
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
                        'url' : '{{ route("admin.payment.purchasedatatable","$paymentheader->id")}}',
                        // success: function(data) {
                        //      alert( JSON.stringify(data));
                        //   // swal( JSON.stringify(data));
                        // },
                        // error: function(xhr, status, error) {
                        //   var err = eval("(" + xhr.responseText + ")");
                        //   alert(xhr.responseText +status + error);
                        // }
                    },
                    columns: [
                        {data: 'purchase_id', width:"20%" , className :"text-left"},
                        {data: 'purchaseno', width:"20%" , className :"text-left"},
                        {data: 'amount', width:"20%", className :"text-right"},
                        {data: 'discount', width:"20%", className :"text-right"},
                        @if($paymentheader->finalized == 0)
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
         var modalPayPurchase = document.getElementById('modalPayPurchase');

          $("#btnAddPayDetails").click(function(){

            $("#formPayDetails").attr('action',"{{ route('admin.payment.storedetail',$paymentheader->id) }}");
          });
          $("#btnAddPayPurchase").click(function(){
            $("#purchase_id").prop('required',true);
            $(".ajax-purchase_id").show();

            $("#purchase_id2").addClass("d-none");
            $("#formPayPurchase").attr('action',"{{ route('admin.payment.storepurchase',$paymentheader->id) }}");
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
              $("#formPayDetails").attr('action',"{{ route('admin.payment.detail.update') }}");
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

            $("#purchase_id2").removeClass("d-none");
            $("#purchase_id").prop('required',false);
            $(".ajax-purchase_id").hide();

            modalPayPurchase.style.display='block';
              $("#formPayPurchase").attr('action',"{{ route('admin.payment.purchase.update',$paymentheader->id) }}");
              // alert("{{$paymentheader->id}}")
             $("#paypurchase_id").val(e);
             purchase_id = $("#table2 #row_inv_"+e+" td:first").text();
             // $("#purchase_id").val(purchase_id).change();
             $("#purchase_id2").val(purchase_id);

             paid_purchase = $("#table2 #row_inv_"+e+" td:nth-child(3)").text();
             discount = $("#table2 #row_inv_"+e+" td:nth-child(4)").text();
             // alert(paid_purchase)
             $("#paid_purchase").val(paid_purchase.replace(",",""));
             $("#discount").val(discount.replace(",",""));
             $("#paid_purchase").focus();


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
