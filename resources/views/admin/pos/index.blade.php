@extends('layouts.backend.app')

@section('title', 'POS')
@section('maintitle', 'Dashboard')
@section('mainUrl',route("admin.dashboard") )

@push('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/bootstrap-select.min.css')}}"/>
    <!-- <link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/ajax-bootstrap-select.css')}}"> -->
    <link rel="stylesheet" href="{{ asset('assets/backend/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/bootstrap-select/css/adjust-select.css')}}"/>

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
          <!--
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12 offset-6">
                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item active">Pos</li>
                        </ol>
                    </div>
                </div>
            </div>

            -->
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-4 product-list">



                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fa fa-shopping-bag"></i> POS</h3>


                             </div>
                              <!-- /.card-header -->



                            <div class="card-body">


                              <form method="POST" action="{{ route('admin.cart.store') }}">
                                  @csrf


                                    <div class="form-group row">
                                        <div class="col-md-12">
                                          <label class="col-md-12">Product</label>
                                          <input type="hidden" id="name" class="form-control"  name="name" value=" ">
                                        </div>
                                        <div class="col-md-12">
                                          <select required="required" id="product_id"  name="product_id" class="selectpicker ajax-product col-md-12" data-live-search="true"></select>
                                          @if ($errors->has('product_id'))
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('product_id') }}</strong>
                                              </span>
                                          @endif

                                        </div>
                                    </div>
                                    <div class="form-group row">


                                        <div class="col-md-12">
                                          <label class="col-md-12">Variant</label>
                                        </div>
                                        <div class="col-md-12">
                                          <select required="required" id="variant_id" name="variant_id" class="selectpicker ajax-variant col-md-12"   data-live-search="true"></select>
                                          @if ($errors->has('variant_id'))
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('variant_id') }}</strong>
                                              </span>
                                          @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6"> <label class="col-md-12">Qty Ordered</label> </div>
                                        <div class="col-md-6">
                                            <input  id="qty" type="number" class="form-control col-sm-12 text-right {{ $errors->has('qty') ? ' is-invalid' : '' }}" name="qty" value="{{ old('qty') }}" required  autofocus>
                                            @if ($errors->has('qty'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('qty') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6"> <label class="col-md-12">Unit Price</label> </div>

                                        <div class="col-md-6">
                                            <input readonly id="selling_price" type="number" class="form-control col-sm-12 text-right {{ $errors->has('selling_price') ? ' is-invalid' : '' }}" name="selling_price" value="{{ old('selling_price') }}" required  autofocus>
                                            @if ($errors->has('selling_price'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('selling_price') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row  d-none ">

                                        <div class="col-md-6"> <label class="col-md-12">Discount</label> </div>
                                        <div class="col-md-6">
                                            <input  id="discount" type="number" class="form-control col-sm-12 text-right {{ $errors->has('discount') ? ' is-invalid' : '' }}" name="discount" value="{{ old('discount') ? ' is-invalid' : '0' }}"   autofocus>
                                            @if ($errors->has('discount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('discount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">

                                        <div class="col-md-6"> <label class="col-md-12">Amount</label> </div>
                                        <div class="col-md-6">
                                            <input  id="amount" type="text" class="form-control col-sm-12 text-right {{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" required disabled  autofocus>
                                            <input  id="total" type="text" class="form-control col-sm-12 text-right {{ $errors->has('total') ? ' is-invalid' : '' }}" name="total" value="{{ old('total') }}" required hidden  autofocus>

                                            @if ($errors->has('amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group  col-sm-4" >
                                      <img class="img-rounded d-none" id ="image" style="height:35px; width: 35px;" data-href="{{URL::asset('product/') }}" src="" alt=" ">
                                    </div>
                                    <div class="form-group float-right col-sm-4" >

                                            <button type="submit" class="btn btn-primary col-sm-12" title="Add to Cart">
                                                <i class="fa fa-cart-plus" aria-hidden="true"></i> {{ __('Add to Cart') }}
                                            </button>


                                    </div>




                              </form>

                            </div>
                            <!-- /.card-body -->
                        </div>



                    </div>
                    <!--/.col (left) -->
                    <!-- .col (right) -->
                    <div class="col-md-8 shopping-list">
                        <!-- general form elements -->

                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fa fa-info"></i>
                                    Shopping Lists

                                </h3>

                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                              <form action="{{ route('admin.invoice.create') }}" method="post">
                                  @csrf
                                  <div class="row">
                                      <div class="col-6" >
                                          <div class="form-group">

                                            <label>Select Customer</label>
                                            <select name="customer_id" class="form-control" required>
                                                <option value="" disabled selected>Select a Customer</option>
                                                @foreach($customers as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                              </select>
                                          </div>

                                      </div>
                                      <div class="col-6" >
                                        <br>
                                        <button type="submits" data-toggle="modal" data-target="#exampleModal" class="btn btn-sm-4 btn-success float-right"><i class="fa fa-shopping-cart"></i>
                                            Checkout
                                        </button>
                                      </div>
                                  </div>
                              </form>
                                <div class="alert alert-info col-md-6 " style="height:105px !important;">


                                    <p>Quantity : {{ Cart::count() }}</p>
                                    <?php
                                      $net  =  floatval(str_replace(",","",Cart::subtotal()));
                                      $gross = ( $net / 1.12) ;
                                      $vat =   ($net - $gross) ; ?>

                                    <p>Gross Total : {{ number_format($gross,2) }} </p>
                                    <p>VAT : {{ number_format($vat,2)  }}</p>
                                    <p>Net Total: {{ Cart::subtotal()   }}</p>

                                    <!-- {{ Cart::tax() }} -->
                                </div>

                                <div class="alert alert-success  col-md-6" style="height:105px !important; font-size: 60px !important; text-align: right !important;">
                                    {{ Cart::subtotal()   }}
                                </div>


                                @if($cart_products->count() < 1)
                                    <!-- <div class="alert alert-danger">
                                        No Product Added
                                    </div> -->
                                @else
                                    <table class="table table-bordered table-striped dataTable text-center mb-3">
                                        <thead>
                                        <tr>

                                            <th width="40%">Name</th>
                                            <th width="7%">Qty</th>
                                            <th width="10%">Price</th>
                                            <th  width="10%">Discount per Qty</th>
                                            <th  width="10%">Amount</th>
                                            <th  width="5%">Update</th>
                                            <th  width="5%">Delete</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                          <script>
                                            // alert("{{$cart_products}}}")
                                          </script>
                                        @foreach($cart_products as $product)
                                            <tr>

                                                <td class="text-left">{{ $product->name }}</td>

                                                <form action="{{ route('admin.cart.update', $product->rowId) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <td>
                                                        <input type="number" min="0"   id = "qty_{{$product->rowId}}" name="qty" class="form-control text-right " value="{{ $product->qty }}">
                                                    </td>
                                                    <td class="text-right">{{ $price = number_format($product->price, 2) }}</td>
                                                    <td>
                                                        <input type="number" min="0"   id = "discount_{{$product->rowId}}" name="discount" class="form-control text-right " value="{{ $product->discount }}">
                                                    </td>
                                                    <td class="text-right">{{ number_format($product->subtotal) }}</td>
                                                    <td>
                                                        <button type="submit" class="btn btn-sm btn-success">
                                                            <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                        </button>
                                                    </td>
                                                </form>

                                                <td>
                                                    <button class="btn btn-danger  btn-sm" type="button" onclick="deleteItem({{ $product->id }})">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </button>
                                                    <form id="delete-form-{{ $product->id }}" action="{{ route('admin.cart.destroy', $product->rowId) }}" method="post"
                                                          style="display:none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

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
    <script src="{{ asset('assets/backend/bootstrap-select/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/backend/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/backend/bootstrap-select/js/ajax-bootstrap-select.js')}}"></script>

    <script>
        $(function () {
          //  $("#example1").DataTable();
            $('#example1').DataTable({

                "searching": true,
                "paging": true,
                "ordering": true,
                "info": false,
                "autoWidth": false,

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

    <!-- Select Options from ajax URL -->
    <script>
        var select_product = {
            ajax          : {
                url     : "{{ route('admin.product.dropdownselect')}}",
                type    : 'get',
                dataType: 'json',
                //
                // success: function(data) {
                //   // swal( JSON.stringify(data));
                //      alert( JSON.stringify(data));
                //   //return mdata;
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
                            text : data[i].name,
                            value: data[i].id,

                            data : {
                                subtext: "Code: " + data[i].code,
                                name : data[i].name,
                                image : data[i].image,
                            }
                        }));
                    }
                }
                // You must always return a valid array when processing data. The
                // data argument passed is a clone and cannot be modified directly.
                return array;
            }
        };

        $('.selectpicker').selectpicker().filter('.ajax-product').ajaxSelectPicker(select_product);
        $('select.ajax-product').trigger('change');
        // //


        var select_variant = {
            serverSide: true,
            ajax          : {
                url     :  "{{ route('admin.product.variantdropdownselect')}}",
                type    : 'get',
                dataType: 'json',
                data    : function() { // This is a function that is run on every request
                       return {
                          id:$("#product_id").val() //this is an input text HTML

                       };
                   },
                // success: function(data) {
                //   // swal( JSON.stringify(data));
                //     // alert(url1);
                //      alert(  JSON.stringify(data));
                // },
                // error: function(xhr, status, error) {
                //   var err = eval("(" + xhr.responseText + ")");
                //   alert(xhr.responseText +status + error);
                // }


            },
            locale        : {
                emptyTitle: 'Select Variant'
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
                            text : data[i].variant + ' ' + data[i].color +' '+data[i].size,
                            value: data[i].id,
                            price: data[i].selling_price,
                            onhand: data[i].onhand,
                            data : {
                                subtext: "Buying Price: " + numberWithCommas(data[i].selling_price) + " | On-Hand: " + data[i].onhand,
                                onhand: data[i].onhand,
                                price: data[i].selling_price,
                                name : data[i].variant + ' ' + data[i].color +' '+data[i].size,
                            }
                        }));
                    }
                }
                // You must always return a valid array when processing data. The
                // data argument passed is a clone and cannot be modified directly.
                return array;
            }

        };



        $('.selectpicker').selectpicker().filter('.ajax-variant').ajaxSelectPicker(select_variant);
        $('select.ajax-variant').trigger('change');
        $('#product_id').on( "change", function(){
            $('#variant_id').val("");
            $('#variant_id').find('option').remove();
            $('#variant_id').selectpicker("refresh");


            // select_variant.refresh();
            if ($(this).find(':selected').data('image')){
              $('#name').val($(this).find(':selected').data('name'));
              $('#image').attr("src", $('#image').data('href')+ "/" + $(this).find(':selected').data('image'));
              $('#image').removeClass("d-none");
            }
        });
        $('#variant_id').change(function(){
            //alert($(this).find(':selected').data('onhand'));

            $("#qty").attr({
               "max" : $(this).find(':selected').data('onhand'),
               "min" : 0
            });
            $('#selling_price').val($(this).find(':selected').data('price'));
            $('#name').val($('#product_id').find(':selected').data('name') + " | "+ $(this).find(':selected').data('name'));
            getTotal();
        });
        $('#qty').change(function(){
            getTotal();
        });
        $('#selling_price').change(function(){
            getTotal();
        });
        $('#discount').change(function(){
            getTotal();
        });

        function getTotal(){

          var qty = parseInt($('#qty').val());
          if (qty > 0){
          }else { qty = 0}
          var price = parseFloat($('#selling_price').val());
          if (price > 0){
          }else { price = 0}

          var discount = parseFloat($('#discount').val());
          if (discount > 0){
          }else { discount = 0}

          var amount  = 0.00;
          if (qty > 0 && price > 0){
             amount  = (qty * price) - discount;
          }
          // alert(amount);
          $('#amount').val(Number(amount).toLocaleString("en",{minimumFractionDigits: 2}));
          $('#total').val(amount);
          // $('#amount').format({format:"###,###,###,###.00", locale:"us"});
        };


        $( document ).ready(function() {
            // alert($(".shopping-list .card").height())

            var h = $(".shopping-list .card").height();
            if (h > $(".product-list .card").height()){
              $(".product-list .card").height(h)
            }else{
              $(".shopping-list .card").height($(".product-list .card").height());

            }

        });
    </script>


@endpush
