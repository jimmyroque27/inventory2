@extends('layouts.backend.app')

@section('title', 'Create Receipt')
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

        </section>

        <!-- Main content -->
        <section class="content">
            <form role="form" action="{{ route('admin.receipt.store') }}" method="post">
              <div class="container-fluid">
                  <div class="row">
                      <!-- left column -->
                      <div class="col-md-12">
                          <!-- general form elements -->
                          <div class="card card-primary">
                              <div class="card-header">
                                  <h3 class="card-title">Create Payment Receipt (Sales Order)</h3>
                              </div>
                              <!-- /.card-header -->

                              <!-- form start -->

                                  @csrf
                                  <div class="card-body">
                                      <div class="col-sm-2">

                                      </div>
                                      <div class="col-sm-8">
                                        <br>  <br>
                                          <div class="row">

                                                <div class="form-group  col-md-12">
                                                    <label   for="customer_id">Customer Name</label>
                                                    <select required id="customer_id" name="customer_id" class="selectpicker ajax-customer w-100" data-live-search="true"></select>

                                                </div>

                                          </div>
                                          <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>O.R. No.</label>
                                                    <input type="text" class="form-control " name="orno" value=" " placeholder="O.R. No.">

                                                </div>
                                            </div>

                                          </div>
                                          <div class="row">

                                            <div class="col-md-12">
                                              <div class="form-group">
                                                  <label>Date</label>
                                                  <input required type="date" class="form-control  " name="receipt_date" value="{{ date('Y-m-d') }}" placeholder="Date of Receipt">
                                              </div>
                                            </div>

                                          </div>
                                          <div class="row ">
                                            <div class="form-group col-sm-12">
                                                <label>Notes</label>
                                                <textarea id="notes" rows="6" cols="50" style="height:100px !important" class="form-control" name="notes"></textarea>
                                              </div>
                                          </div>
                                      </div>

                                      <div class="col-sm-2">
                                      </div>
                                  </div>
                                  <!-- /.card-body -->
                                  <div class="card-footer">
                                      <button type="submit" class="btn btn-primary float-md-right">Save Customer Receipt</button>
                                  </div>
                                  <!-- <div class="card-footer">
                                      <a href="#"    class="btn btn-primary float-md-right"><span>Save</span></a>

                                  </div> -->


                          </div>
                          <!-- /.card -->
                      </div>
                      <!--/.col (left) -->
                  </div>
                  <!-- /.row -->
              </div><!-- /.container-fluid -->


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
      var sellect_customer = {
          ajax          : {
              url     : "{{ route('admin.customer.dropdownselect')}}",
              type    : 'get',

              dataType: 'json',
              //
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
                          text : data[i].name,
                          value: data[i].id,
                          data : {
                              subtext: data[i].shop_name + " | " + data[i].email +" | Balance: " + data[i].balance.toLocaleString()
                          }
                      }));
                  }
              }
              // You must always return a valid array when processing data. The
              // data argument passed is a clone and cannot be modified directly.
              return array;
          }
      };

      $('.selectpicker').selectpicker().filter('.ajax-customer').ajaxSelectPicker(sellect_customer);
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
                          price: data[i].buying_price,
                          onhand: data[i].onhand,
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
      $('#product_id').change(function(){
        $('#variant_id').val("");
        $('#variant_id').find('option').remove();
        $('#variant_id').selectpicker("refresh");


      });
      $('#variant_id').change(function(){
          //alert($(this).find(':selected').data('onhand'));
          $('#receipt_price').val($(this).find(':selected').data('price'));
          getTotal();
      });
      $('#qty').change(function(){
          getTotal();
      });
      $('#receipt_price').change(function(){
          getTotal();
      });
      $('#discount').change(function(){
          getTotal();
      });

      function getTotal(){

        var qty = parseInt($('#qty').val());
        if (qty > 0){
        }else { qty = 0}
        var price = parseFloat($('#receipt_price').val());
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
