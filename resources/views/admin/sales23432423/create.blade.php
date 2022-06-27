@extends('layouts.backend.app')

@section('title', 'Create Purchase')
@section('maintitle', 'Purchases')
@section('mainUrl',route("admin.purchase.index") )

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
            <!-- <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 offset-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Create Category</li>
                        </ol>
                    </div>
                </div>
            </div> -->
            <!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <form role="form" action="{{ route('admin.purchase.store') }}" method="post">
              <div class="container-fluid">
                  <div class="row">
                      <!-- left column -->
                      <div class="col-md-12">
                          <!-- general form elements -->
                          <div class="card card-primary">
                              <div class="card-header">
                                  <h3 class="card-title">New Purchase Order</h3>
                              </div>
                              <!-- /.card-header -->

                              <!-- form start -->

                                  @csrf
                                  <div class="card-body">
                                      <div class="row">
                                          <div class="col-md-5">
                                              <div class="form-group ">
                                                  <label   for="supplier_id">Supplier Name</label>
                                                  <select required id="supplier_id" name="supplier_id" class="selectpicker ajax-supplier col-md-12" data-live-search="true"></select>

                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                              <div class="form-group">
                                                  <label>Reference No.</label>
                                                  <input type="text" class="form-control col-md-12" name="refno" value=" " placeholder="Reference No.">

                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                            <div class="form-group">
                                                <label  >Date</label>
                                                <input required type="date" class="form-control col-md-12" name="purchase_date" value="{{ date('Y-m-d') }}" placeholder="Date of Purchase">
                                            </div>
                                          </div>
                                          <div class="col-md-2">
                                            <div class="form-group">
                                                <label   >Due Date</label>
                                                <input required type="date" class="form-control col-md-12" name="due_date" value="{{ date('Y-m-d') }}" placeholder="Due Date">
                                            </div>
                                          </div>
                                      </div>
                                      <div class="row">

                                        <table id="example1" width="100%" class="table table-bordered table-striped text-center table-responsive-xl">
                                            <thead>
                                            <tr>
                                                <th width="35%" class="align-middle">Name</th>
                                                <th width="15%" class="align-middle">Code</th>
                                                <th width="15%" class="align-middle">Variant</th>
                                                <th width="10%" class="align-middle">Quantity</th>
                                                <th width="10%" class="align-middle">Unit Price</th>
                                                <th width="10%" class="align-middle">Amount</th>
                                                <th width="15%" class="align-middle">Actions</th>

                                            </tr>
                                            </thead>

                                            <tbody>

                                            </tbody>

                                        </table>

                                      </div>
                                  </div>
                                  <!-- /.card-body -->
                                  <!-- <div class="card-footer">
                                      <button type="submit" class="btn btn-primary float-md-right">Add Item</button>
                                  </div> -->
                                  <div class="card-footer">
                                      <a href="#" onclick="document.getElementById('AddItem').style.display='block'"  class="btn btn-primary float-md-right"><span>Add Item</span></a>

                                  </div>


                          </div>
                          <!-- /.card -->
                      </div>
                      <!--/.col (left) -->
                  </div>
                  <!-- /.row -->
              </div><!-- /.container-fluid -->

              <div id="AddItem" class="modal">
                <div class="modal-dialog modal-lg" >
                  <div class="modal-content animate  " style="">
                    <div class="modal-header bg-success">
                      <h5 class="modal-title" id="exampleModalCenterTitle">Purchase | Add Item
                          <span onclick="document.getElementById('AddItem').style.display='none'" class="close" title="Close Modal">&times;</span>
                      </h5>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="{{ route('admin.purchase.storeProduct') }}">
                          @csrf


                            <div class="form-group row">
                                <div class="col-md-4"> Product </div>
                                <div class="col-md-8">

                                    <select required="required" id="product_id"  name="product_id" class="selectpicker ajax-product " data-live-search="true"></select>
                                    @if ($errors->has('product_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('product_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">Variant</div>
                                <div class="col-md-8">

                                    <select required="required" id="variant_id" name="variant_id" class="selectpicker ajax-variant "   data-live-search="true"></select>
                                    @if ($errors->has('variant_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('variant_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4"> Qty Ordered </div>
                                <div class="col-md-8">
                                    <input  id="qty" type="number" class="form-control col-sm-6 text-right {{ $errors->has('qty') ? ' is-invalid' : '' }}" name="qty" value="{{ old('qty') }}" required  autofocus>
                                    @if ($errors->has('qty'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('qty') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4"> Buying Price </div>
                                <div class="col-md-8">
                                    <input  id="purchase_price" type="number" class="form-control col-sm-6 text-right {{ $errors->has('purchase_price') ? ' is-invalid' : '' }}" name="purchase_price" value="{{ old('purchase_price') }}" required  autofocus>
                                    @if ($errors->has('purchase_price'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('purchase_price') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4"> Discount </div>
                                <div class="col-md-8">
                                    <input  id="discount" type="number" class="form-control col-sm-6 text-right {{ $errors->has('discount') ? ' is-invalid' : '' }}" name="discount" value="{{ old('discount') ? ' is-invalid' : '0' }}"   autofocus>
                                    @if ($errors->has('discount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('discount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4"> Amount </div>
                                <div class="col-md-8">
                                    <input  id="amount" type="text" class="form-control col-sm-6 text-right {{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" value="{{ old('amount') }}" required disabled  autofocus>
                                    <input  id="total" type="text" class="form-control col-sm-6 text-right {{ $errors->has('total') ? ' is-invalid' : '' }}" name="total" value="{{ old('total') }}" required hidden  autofocus>

                                    @if ($errors->has('amount'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('amount') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group float-right" >
                                    <button type="submit" class="btn btn-primary" title="Save Item">
                                        {{ __('Save') }}
                                    </button>
                                      <span onclick="document.getElementById('AddItem').style.display='none'" class="btn btn-dark" title="Close Modal">{{ __('Close') }}</span>


                            </div>




                      </form>
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

<!--
<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="https://www.jqueryscript.net/demo/AJAX-Autocomplete-Bootstrap-Select/dist/js/ajax-bootstrap-select.js"></script> -->

  <script>
      var sellect_supplier = {
          ajax          : {
              url     : "{{ route('admin.supplier.dropdownselect')}}",
              type    : 'get',
              //
              // url     : "{{ asset('assets/backend/bootstrap-select/example/php/ajax.php') }}",
              // type    : 'post',

              dataType: 'json',
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
          locale        : {
              emptyTitle: 'Select and Begin Typing'
          },
          // log           : 3,
          preprocessData: function (data) {
              var i, l = data.length, array = [];
              if (l) {
                  for (i = 0; i < l; i++) {
                      array.push($.extend(true, data[i], {
                          text : data[i].name,
                          value: data[i].id,
                          data : {
                              subtext: data[i].shop_name + " | " + data[i].email
                          }
                      }));
                  }
              }
              // You must always return a valid array when processing data. The
              // data argument passed is a clone and cannot be modified directly.
              return array;
          }
      };

      $('.selectpicker').selectpicker().filter('.ajax-supplier').ajaxSelectPicker(sellect_supplier);
      $('select').trigger('change');
  </script>
  <script>
    // Get the modal
    var modal = document.getElementById('AddItem');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
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
          // log           : 3,
          preprocessData: function (data) {
              var i, l = data.length, array = [];
              if (l) {
                  for (i = 0; i < l; i++) {
                      array.push($.extend(true, data[i], {
                          text : data[i].name,
                          value: data[i].id,
                          data : {
                              subtext: "Code: " + data[i].code
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
          // log           : 3,
          preprocessData: function (data) {
              var i, l = data.length, array = [];
              if (l) {
                  for (i = 0; i < l; i++) {
                      array.push($.extend(true, data[i], {
                          text : data[i].variant + ' ' + data[i].color +' '+data[i].size,
                          value: data[i].id,
                          price: data[i].buying_price,
                          onhand: data[i].buying_price,
                          data : {
                              subtext: "Buying Price: " + numberWithCommas(data[i].buying_price) + " | On-Hand: " + data[i].onhand,
                              onhand: data[i].onhand,
                              price: data[i].buying_price,
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
      $('#variant_id').change(function(){
          //alert($(this).find(':selected').data('onhand'));
          $('#purchase_price').val($(this).find(':selected').data('price'));
          getTotal();
      });
      $('#qty').change(function(){
          getTotal();
      });
      $('#purchase_price').change(function(){
          getTotal();
      });
      $('#discount').change(function(){
          getTotal();
      });

      function getTotal(){

        var qty = parseInt($('#qty').val());
        if (qty > 0){
        }else { qty = 0}
        var price = parseFloat($('#purchase_price').val());
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

  </script>

@endpush
