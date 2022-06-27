@extends('layouts.backend.app')

@section('title', 'Purchase Details')
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
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Purchase Transaction
                                  <?php
                                    $addBtn = route('admin.purchase.create');
                                    $BtnCaption = "New Purchase" ;
                                  ?>
                                  @include('includes._datatable_actions')

                                </h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->

                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group ">
                                                <label   for="supplier_id">Supplier Name: </label>
                                                {{ $purchaseheader->supplier->name}}

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Trans. No.: </label>
                                                {{ $purchaseheader->id}}

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Reference No. :</label>
                                                {{ $purchaseheader->refno}}

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                          <div class="form-group">
                                              <label  >Date: </label>
                                              {{ $purchaseheader->purchase_date}}
                                          </div>
                                        </div>
                                        <div class="col-md-2">
                                          <div class="form-group">
                                              <label   >Due Date:</label>
                                              {{ $purchaseheader->due_date}}
                                          </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                      <table id="example1" width="100%" class="table table-bordered table-striped text-center table-responsive-xl">
                                          <thead>
                                          <tr>
                                              <th width="25%" class="align-middle">Name</th>
                                              <th width="10%" class="align-middle">Code</th>
                                              <th width="8%" class="align-middle">Variant</th>
                                              <th width="8%" class="align-middle">Color</th>
                                              <th width="8%" class="align-middle">Size</th>
                                              <th width="8%" class="align-middle">Quantity</th>
                                              <th width="8%" class="align-middle">Unit Price</th>
                                              <th width="10%" class="align-middle">Discount</th>
                                              <th width="10%" class="align-middle">Amount</th>
                                              @if($purchaseheader->finalized == 0)
                                                <th width="15%" class="align-middle">Actions</th>
                                              @endif
                                          </tr>
                                          </thead>

                                          <tbody>

                                          </tbody>
                                          <tfoot>
                                            <tr>

                                                <td colspan="8" width="10%">TOTAL</td>
                                                <td width="10%">{{ number_format($purchaseheader->total,2) }}</td>
                                                @if($purchaseheader->finalized == 0)
                                                  <td width="15%"></td>
                                                @endif

                                            </tr>

                                          </tfoot>

                                      </table>
                                      <div class="col-md-12">
                                        <div class="form-group">
                                            <label   >Note:</label>
                                            {{ $purchaseheader->purchase_status}}
                                        </div>
                                      </div>

                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    @if($purchaseheader->finalized == 0)
                                      <a href="{{ route('admin.purchase.finalized',$purchaseheader->id) }}" onclick="finalizeConfirm()" class="btn btn-warning  offset-sm-1 float-md-right"><span>Finalize</span></a>
                                      <a href="#" onclick="document.getElementById('AddNote').style.display='block'" id="btnaddnote"  class="btn btn-info offset-sm-1 float-md-right"><span>Add Note</span></a>
                                      <a href="#" onclick="document.getElementById('AddItem').style.display='block'"  id="btnadditem" class="btn btn-primary offset-sm-1 float-md-right"><span>Add Item</span></a>
                                    @endif
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
                                  <input type="text" id ="purchase_id" name ="purchase_id" value ="{{ $purchaseheader->id}}" hidden>
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



            <div id="EditItem" class="modal">
              <div class="modal-dialog modal-lg" >
                <div class="modal-content animate  " style="">
                  <div class="modal-header bg-secondary">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Purchase | Edit Item
                        <span onclick="document.getElementById('EditItem').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </h5>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="" id ="formEditItem">
                        @csrf


                          <div class="form-group row">
                              <div class="col-md-4"> Product </div>
                              <div class="col-md-8">
                                  <input type="text" id ="purchase_id2" name ="purchase_id2" value ="{{ $purchaseheader->id}}" hidden>
                                  <input type="text" id ="id2" name = "id2"   hidden>


                                  <span id ="name2"  ></span>
                              </div>
                          </div>
                          <div class="form-group row">
                              <div class="col-md-4">Variant</div>
                              <div class="col-md-8">
                                  <!-- <input type="text" width="100%" id ="variant2" name ="variant2" value ="" readonly> -->
                                  <span id ="variant2"  ></span>
                              </div>
                          </div>
                          <div class="form-group row">
                              <div class="col-md-4"> Qty Ordered </div>
                              <div class="col-md-8">
                                  <input  id="qty2" type="number" class="form-control col-sm-6 text-right {{ $errors->has('qty2') ? ' is-invalid' : '' }}" name="qty2" value="{{ old('qty2') }}" required  autofocus>
                                  @if ($errors->has('qty2'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('qty2') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <div class="col-md-4"> Buying Price </div>
                              <div class="col-md-8">
                                  <input  id="purchase_price2" type="number" class="form-control col-sm-6 text-right {{ $errors->has('purchase_price2') ? ' is-invalid' : '' }}" name="purchase_price2" value="{{ old('purchase_price2') }}" required  autofocus>
                                  @if ($errors->has('purchase_price2'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('purchase_price2') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <div class="col-md-4"> Discount </div>
                              <div class="col-md-8">
                                  <input  id="discount2" type="number" class="form-control col-sm-6 text-right {{ $errors->has('discount2') ? ' is-invalid' : '' }}" name="discount2" value="{{ old('discount2') ? ' is-invalid' : '0' }}"   autofocus>
                                  @if ($errors->has('discount2'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('discount2') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group row">
                              <div class="col-md-4"> Amount </div>
                              <div class="col-md-8">
                                  <input  id="amount2" type="text" class="form-control col-sm-6 text-right {{ $errors->has('amount2') ? ' is-invalid' : '' }}" name="amount2" value="{{ old('amount2') }}" required disabled  autofocus>
                                  <input  id="total2" type="text" class="form-control col-sm-6 text-right {{ $errors->has('total2') ? ' is-invalid' : '' }}" name="total2" value="{{ old('total2') }}" required hidden  autofocus>

                                  @if ($errors->has('amount2'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('amount2') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>

                          <div class="form-group float-right" >
                                  <button type="submit" class="btn btn-primary" title="Save Item">
                                      {{ __('Save') }}
                                  </button>
                                    <span onclick="document.getElementById('EditItem').style.display='none'" class="btn btn-dark" title="Close Modal">{{ __('Close') }}</span>


                          </div>




                    </form>
                  </div>
                </div>
              </div>
            </div>

            <div id="AddNote" class="modal">
              <div class="modal-dialog modal-lg" >
                <div class="modal-content animate  " style="">
                  <div class="modal-header bg-success">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Purchase | Add Note
                        <span onclick="document.getElementById('AddNote').style.display='none'" class="close" title="Close Modal">&times;</span>
                    </h5>
                  </div>
                  <div class="modal-body">
                    <form method="POST" action="{{ route('admin.purchase.storeNote',$purchaseheader->id) }}">
                        @csrf


                          <div class="form-group row">
                              <div class="col-md-12"> Note </div>
                              <div class="col-md-12">
                                  <textarea  id ="purchase_status" name ="purchase_status"  style="height:60px !important" class="form-control" >{{ $purchaseheader->purchase_status}}</textarea>
                                  <!-- <input id ="purchase_status" name ="purchase_status" value ="{{ $purchaseheader->purchase_status}}" style="height:60px !important" class="form-control" rows="5" > -->
                                  @if ($errors->has('purchase_status'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('purchase_status') }}</strong>
                                      </span>
                                  @endif
                              </div>
                          </div>
                          <div class="form-group float-right" >
                                  <button type="submit" class="btn btn-primary" title="Save Item">
                                      {{ __('Save') }}
                                  </button>
                                    <span onclick="document.getElementById('AddNote').style.display='none'" class="btn btn-dark" title="Close Modal">{{ __('Close') }}</span>


                          </div>




                    </form>
                  </div>
                </div>
              </div>
            </div>

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
            $(document).ready(function(){
                var table = $('#example1').DataTable({
                    serverSide: true,
                    method: "post",
                    "searching": false,
                    "paging": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,

                    ajax: {
                        'url' : '{{ route("admin.purchase.productdatatable","$purchaseheader->id")}}',
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
                        {data: 'name', width:"32%" , className :"text-left"},
                        {data: 'code', width:"10", className :"text-left"},
                        {data: 'variant', width:"8%", className :"text-left"},
                        {data: 'color', width:"8%", className :"text-left"},
                        {data: 'size', width:"8%", className :"text-left"},
                        {data: 'qty', width:"8%", className :"text-right"},
                        {data: 'purchase_price', width:"8%", className :"text-right"},
                        {data: 'discount', width:"8%", className :"text-right"},
                        {data: 'amount', width:"8%", className :"text-right"},
                        @if($purchaseheader->finalized == 0)
                          {data: 'actions', width:"10%", className :"text-leftL actionsCol"},
                        @endif

                    ],
                    columnDefs: [
                      {
                       targets:5,

                       render: $.fn.dataTable.render.number(',', '.', 0, '')
                      },
                      {
                       targets:6,
                       render: $.fn.dataTable.render.number(',', '.', 2, '')
                      },
                      {
                       targets:7,
                       render: $.fn.dataTable.render.number(',', '.', 2, '')
                      },
                      {
                       targets:8,
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
        <script>
          // Get the modal
          var modalItem = document.getElementById('AddItem');
          var modalEditItem = document.getElementById('EditItem');
          var modalNote = document.getElementById('AddNote');
          // When the user clicks anywhere outside of the modal, close it
          // window.onclick = function(event) {
          //     //$("#product_id").focus();
          //     if (event.target == modalItem) {
          //         modalItem.style.display = "none";
          //     }else{
          //
          //     }
          // }
          $("#btnaddnote").click(function(){
            $("#purchase_status").focus();
          });
          $("#btnadditem").click(function(){
            $("#product_id").focus();
          });

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

            $("#id2").val(e.toString());
            // alert($("#id2").val());
            $("#name2").html($("#example1 #"+e+" td:first").html());
            $("#variant2").html($("#example1 #"+e+" td:nth-child(3)").html() +" "+$("#example1 #"+e+" td:nth-child(4)").html() +" " +$("#example1 #"+e+" td:nth-child(5)").html());
            $("#qty2").val($("#example1 #"+e+" td:nth-child(6)").html().replace(/,/g , ''));
            $("#purchase_price2").val($("#example1 #"+e+" td:nth-child(7)").html().replace(/,/g , ''));
            $("#discount2").val($("#example1 #"+e+" td:nth-child(8)").html().replace(/,/g , ''));
            $("#amount2").val($("#example1 #"+e+" td:nth-child(9)").html());
            $("#total2").val($("#example1 #"+e+" td:nth-child(9)").html());
            // alert();
              document.getElementById('EditItem').style.display='block';
              $('#formEditItem').attr('action', "{{ route('admin.purchase.updateProduct') }}")
          }

          $('#qty2').change(function(){
              getTotal2();
          });
          $('#purchase_price2').change(function(){
              getTotal2();
          });
          $('#discount2').change(function(){
              getTotal2();
          });

          function getTotal2(){

            var qty = parseInt($('#qty2').val());
            if (qty > 0){
            }else { qty = 0}
            var price = parseFloat($('#purchase_price2').val());
            if (price > 0){
            }else { price = 0}

            var discount = parseFloat($('#discount2').val());
            if (discount > 0){
            }else { discount = 0}

            var amount  = 0.00;
            if (qty > 0 && price > 0){
               amount  = (qty * price) - discount;
            }
            // alert(amount);
            $('#amount2').val(Number(amount).toLocaleString("en",{minimumFractionDigits: 2}));
            $('#total2').val(amount);
            // $('#amount').format({format:"###,###,###,###.00", locale:"us"});
          };
        </script>
@endpush
