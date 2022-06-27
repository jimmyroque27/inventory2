@extends('layouts.backend.app')

@section('title', 'Invoice')
@section('maintitle', 'POS')
@section('mainUrl',route('admin.pos.index') )

@push('css')
    <style>
        .modal-lg {
            max-width: 50% !important;
        }
        .bottom-line{
          /* border : 1rem #333 !important; */
          border-bottom: solid #ccc !important;
          padding-bottom: 5px;
          margin-bottom: 5px;
        }
    </style>
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!-- <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Invoice</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Invoice</li>
                        </ol>
                    </div>
                </div>
            </div> -->
            <!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <!-- <div class="col-12"> -->
                                    <div  class="col-5">
                                      <h4>
                                        <img src="{{ asset('assets/backend/img/') }}/{{config('holdings.OWNER.OWNER_LOGO')}}" alt="Logo"
                                             style="opacity: .9; width:30px; height:30px;"> {{ config('holdings.OWNER.OWNER_NAME') }}
                                      </h4>
                                    </div>
                                    <div  class="col-2 text-center">
                                      <h4>SALES INVOICE</h4>
                                    </div>
                                    <div  class="col-5 ">
                                      <span class="float-right">Date: {{ date('l, d-M-Y h:i:s A') }}</span>
                                    </div>


                                <!-- </div> -->
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    From
                                    <address>
                                        <strong>{{ config('holdings.OWNER.OWNER_NAME') }}</strong><br>
                                          {{ config('holdings.OWNER.OWNER_ADDRESS') }}<br>
                                          Phone: +63 {{ config('holdings.OWNER.OWNER_CONTACT') }}<br>
                                          Email: {{ config('holdings.OWNER.OWNER_EMAIL') }}


                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    To
                                    <address>
                                        <strong>{{ $customer->name }}</strong><br>
                                        {{ $customer->address }}<br>
                                        <!-- {{ $customer->city }}<br> -->
                                        Phone: (+63) {{ $customer->phone }}<br>
                                        Email: {{ $customer->email }}
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Payment Due:</b> {{ Cart::total() }}<br>
                                    <b>Order Status:</b> <span class="badge badge-warning">Pending</span><br>
                                    <b>Account:</b> {{ $customer->account_number }}
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-bordered  ">
                                        <thead>
                                        <tr class="text-center">
                                            <th width="6%" >S.N</th>
                                            <th width="64%" >Item</th>
                                            <th width="10%" >Quantity</th>
                                            <th width="10%"  >Unit Price</th>
                                            <th width="10%"  >Unit Discount</th>
                                            <th width="10%"  >Amount</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($contents as $content)
                                                <tr>
                                                    <td class="text-right">{{ $loop->iteration }}</td>
                                                    <td>{{ $content->name }}</td>
                                                    <td class="text-right">{{ $content->qty }}</td>
                                                    <td class="text-right">{{ number_format($content->price, 2) }}</td>
                                                    <td class="text-right">{{ number_format($content->discount, 2) }}</td>
                                                    <td class="text-right">{{ $content->subtotal() }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-8"></div>
                                <!-- /.col -->
                                <div class="col-4">
                                  <h6>
                                    <?php
                                      $net  =  floatval(str_replace(",","",Cart::subtotal()));
                                      $gross = ( $net / 1.12) ;
                                      $vat =   ($net - $gross) ; ?>


                                      <div class="row col-sm-12 bottom-line">
                                          <div class="col-md-6">Gross Total: </div>
                                          <div class="col-md-6 text-right">{{ number_format($gross,2) }} </div>
                                      </div>

                                      <div class="row col-sm-12 bottom-line">
                                          <div class="col-md-6">VAT (12%): </div>
                                          <div class="col-md-6 text-right">{{ number_format($vat,2)  }} </div>
                                      </div>
                                      <div class="row col-sm-12 bottom-line">
                                          <div class="col-md-6">Net Total: </div>
                                          <div class="col-md-6 text-right">{{ Cart::subtotal() }} </div>
                                      </div>
                                  </h6>
                                  <br>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="{{ route('admin.invoice.print', $customer->id) }}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                                    <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-success float-right"><i class="fa fa-credit-card"></i>
                                        Submit Payment
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!--payment modal -->
    <form action="{{ route('admin.invoice.final_invoice') }}" method="post">
        @csrf
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Invoice of {{ $customer->name }}
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <p class="text-info float-right mb-3">Payable Total : {{ Cart::total() }}</p>
                            </div>
                        </div>
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
                                <input type="number" name="pay" class="form-control" max="{{ $net  }}" value="{{ $net  }}">
                            </div>
                        </div>
                        <div class="form-row d-none Pay-Details">
                          <div class="form-group col-md-6">
                              <label for="inputmerchant_id" >Bank/Merchant</label>
                              <select name="merchant_id" class="form-control Cash"  >
                                  <option value="" disabled selected>Select a Bank/Merchant</option>
                                  @foreach($merchants as $merchant)
                                      <option value="{{ $merchant->id }}"  >{{ $merchant->name }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group col-md-6">
                              <label for="inputrefname" class='input-refname'>Name</label>
                              <input type="text" name="refname" class="form-control" >
                          </div>

                        </div>
                        <div class="form-row  d-none Pay-Details">
                          <div class="form-group col-md-6">
                              <label for="inputrefno" class='input-refno'>No.</label>
                              <input type="text" name="refno"  class="form-control">
                          </div>
                          <div class="form-group col-md-6">
                              <label for="inputrefdate" class='input-refdate'>Date</label>
                              <input type="date" name="refdate" class="form-control" >
                          </div>
                        </div>
                        <div class="form-row  d-none Pay-Details2">
                          <div class="form-group col-md-6">
                              <label for="inputrefname" class='input-approval_id'>Approval No.</label>
                              <input type="text" name="approval_id"  class="form-control">
                          </div>
                          <div class="form-group col-md-6">
                              <label for="inputrefdate" class='input-approval_date'>Approval Date</label>
                              <input type="date" name="approval_date" class="form-control" >
                          </div>
                        </div>
                    </div>
                    <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--/.payment modal -->



@endsection



@push('js')
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
