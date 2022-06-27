<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>e-\Receipt - {{ config('app.name', 'Inventory Management System') }}</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/font-awesome/css/font-awesome.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="icon" href="{{ asset('assets/backend/img/policymaker.ico') }}" type="image/x-icon" />

</head>

<body>
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
                              <h4>e-Receipt</h4>
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
                              <strong>{{ $receiptheader->customer->name }}</strong><br>
                              {{ $receiptheader->customer->address }}<br>

                              Phone: (+63) {{ $receiptheader->customer->phone }}<br>
                              Email: {{ $receiptheader->customer->email }}
                          </address>

                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>O.R. No.: </b> {{$receiptheader->orno }}<br><br>
                            <b>Date: </b> {{$receiptheader->receipt_date }}<br><br>
                            <b>Receipt ID:</b> {{ str_pad($receiptheader->id,9,"0",STR_PAD_LEFT) }}<br>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-6 table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                <tr>

                                    <th>Payment Method</th>
                                    <th>Particulars</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach($receiptdetails as $receiptdetail)
                                      <tr>
                                          <td>{{ $receiptdetail->name }}</td>
                                          <td>{{ $receiptdetail->refname ." ".$receiptdetail->refno }}</td>
                                          <td class="text-right">{{ number_format(($receiptdetail->amount), 2) }}</td>
                                      </tr>
                                  @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="col-6 table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                <tr>

                                    <th>Order ID</th>
                                    <th>Invoice No.</th>

                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach($receiptinvoices as $receiptinvoice)
                                      <tr>
                                          <td>{{ $receiptinvoice->order_id }}</td>
                                          <td>{{ $receiptinvoice->invoiceno }}</td>
                                          <td class="text-right">{{ number_format(($receiptinvoice->amount), 2) }}</td>
                                      </tr>
                                  @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">

                        <div class="col-4 offset-4">

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->


                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <!-- /.content -->

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('assets/backend/js/adminlte.js') }}"></script>

<script>
    window.print();
</script>

</body>



</html>
