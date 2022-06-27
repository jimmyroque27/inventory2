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
                                <h3 class="card-title">Purchase Transaction</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->

                              <form method="post" action="{{ route('admin.purchase.update',$purchaseheader->id) }}">
                              @csrf
                                <div class="card-body">
                                    <div class="row">
                                          <div class="col-md-5">
                                              <div class="form-group ">
                                                  <label   for="supplier_id">Supplier Name</label>
                                                  <select required id="supplier_id" name="supplier_id" class="selectpicker ajax-supplier col-md-12" data-live-search="true">
                                                    <option value = "{{$purchaseheader->supplier_id}}">{{$purchaseheader->supplier->name}}</option>
                                                  </select>

                                              </div>
                                          </div>
                                          <div class="col-md-3">
                                              <div class="form-group">
                                                  <label>Reference No.</label>
                                                  <input type="text" class="form-control col-md-12" name="refno" value = "{{$purchaseheader->refno}}" placeholder="Reference No.">

                                              </div>
                                          </div>
                                          <div class="col-md-2">
                                            <div class="form-group">
                                                <label  >Date</label>
                                                <input required type="date" class="form-control col-md-12" name="purchase_date" value = "{{$purchaseheader->purchase_date}}"  placeholder="Date of Purchase">
                                            </div>
                                          </div>
                                          <div class="col-md-2">
                                            <div class="form-group">
                                                <label   >Due Date</label>
                                                <input required type="date" class="form-control col-md-12" name="due_date" value = "{{$purchaseheader->due_date}}" placeholder="Due Date">
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
                                            <textarea  id ="purchase_status" name ="purchase_status"  style="height:60px !important" class="form-control" >{{ $purchaseheader->purchase_status}}</textarea>
                                            @if ($errors->has('purchase_status'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('purchase_status') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                      </div>

                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    @if($purchaseheader->finalized == 0)
                                      <button type="submit" class="btn btn-primary float-md-right" title="Update Purchase Header">
                                          {{ __('Save Header') }}
                                      </button>
                                    @endif
                                </div>

                              </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>

                <!-- /.row -->
            </div><!-- /.container-fluid -->


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
                $("#supplier_id").focus();
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
          finalizeConfirm(){
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
                    } else if (
                        // Read more about handling dismissals
                        return false;
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
