@extends('layouts.backend.app')

@section('title', 'Add Product')
@section('maintitle', 'Products')
@section('mainUrl',route("admin.product.index") )

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
        <!-- <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 offset-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Product</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section> -->
        <br>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Product</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Product Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter Product Name">
                                            </div>
                                            <div class="form-group">
                                                <label>Product Category</label>
                                                <select name="category_id" class="form-control" value="{{ old('category_id') }}" required>
                                                    <option value="" disabled selected>Select a Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                              <div class="form-group ">
                                                  <label   for="supplier_id">Supplier Name</label>
                                                  <select required id="supplier_id" name="supplier_id" value="{{ old('supplier_id') }}"  class="selectpicker ajax-supplier col-md-12" data-live-search="true"></select>

                                              </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Product Code</label>
                                                <input type="text" class="form-control" name="code" value="{{ old('code') }}" placeholder="Enter Product Code">
                                            </div>
                                            <div class="form-group">
                                                <label>Garage</label>
                                                <select name="garage" class="form-control" value="{{ old('garage') }}" required>
                                                    <option value="" disabled selected>Select a Garage</option>
                                                    <option value="A">Garage A</option>
                                                    <option value="B">Garage B</option>
                                                    <option value="C">Garage C</option>
                                                    <option value="D">Garage D</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Route</label>
                                                <select name="route" class="form-control" value="{{ old('route') }}" required>
                                                    <option value="" disabled selected>Select a Route</option>
                                                    <option value="A">Route A</option>
                                                    <option value="B">Route B</option>
                                                    <option value="C">Route C</option>
                                                    <option value="D">Route D</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Product Image</label>
                                                <div class="input-group">
                                                    <div class="custom-file col-sm-8">
                                                        <input type="file" name="image" class="custom-file-input" id="exampleInputFile" accept="image/png, image/gif, image/jpeg, image/jpg, image/svg">
                                                        <label class="custom-file-label" id="labelInputFile" for="exampleInputFile">Choose file</label>
                                                    </div>

                                                    <div class="col-sm-4">
                                                      <img class="  table-bordered" style="padding:10px" id="prod-img" width="100px" height="100px" src=" " alt=" ">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Buying Date</label>
                                                <input type="date" class="form-control" name="buying_date" value="{{ old('buying_date') }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Expire Date</label>
                                                <input type="date" class="form-control" name="expire_date" value="{{ old('expire_date') }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Buying Price</label>
                                                <input type="text" class="form-control" name="buying_price" value="{{ old('buying_price') }}" placeholder="Enter Buying Price">
                                            </div>
                                            <div class="form-group">
                                                <label>Selling Price</label>
                                                <input type="text" class="form-control" name="selling_price" value="{{ old('selling_price') }}" placeholder="Enter Selling Price">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary float-md-right">Add Product</button>
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
  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#prod-img').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }


  $("#exampleInputFile").change(function(){
      readURL(this);
      var filePath=$(this).val();
      $("#labelInputFile").html(filePath);
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
@endpush
