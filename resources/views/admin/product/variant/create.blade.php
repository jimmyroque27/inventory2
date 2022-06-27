@extends('layouts.backend.app')

@section('title', 'Add Product')
@section('maintitle', 'Product View')
@section('mainUrl',route("admin.product.show",$product) )

@push('css')

@endpush

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <!-- <div class="row mb-2">
                    <div class="col-sm-6 offset-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Add Variants</li>
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
                                <h3 class="card-title">Add Product Variant</h3>
                            </div>
                            <!-- /.card-header -->

                            <!-- form start -->
                            <form role="form" action="{{ route('admin.product.variant.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Variant</label>

                                                <input hidden type="text" class="form-control" name="product_id" value="{{$product->id}}" placeholder="Enter Variant">
                                                <input type="text" class="form-control" name="variant" value="{{ old('variant') }}" placeholder="Enter Variant">
                                            </div>
                                            <div class="form-group">
                                                <label>Color</label>
                                                <select name="color" class="form-control">
                                                    <option value="" disabled selected>Select a Color</option>
                                                    @foreach($colors as $color)
                                                        <option value="{{ $color->name }}">{{ $color->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Sizes</label>
                                                <select name="size" class="form-control">
                                                    <option value="" disabled selected>Select a Sizes</option>
                                                    @foreach($sizes as $size)
                                                        <option value="{{ $size->name }}">{{ $size->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-6">

                                            <!-- <div class="form-group">
                                                <label>Buying Date</label>
                                                <input type="date" class="form-control" name="buying_date" value="{{ old('buying_date') }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Expire Date</label>
                                                <input type="date" class="form-control" name="expire_date" value="{{ old('expire_date') }}">
                                            </div> -->
                                            <div class="form-group">
                                                <label>Buying Price</label>
                                                <input type="number" class="form-control" name="buying_price" value="{{ old('buying_price') }}" placeholder="Enter Buying Price">
                                            </div>
                                            <div class="form-group">
                                                <label>Selling Price</label>
                                                <input type="number" class="form-control" name="selling_price" value="{{ old('selling_price') }}" placeholder="Enter Selling Price">
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
@endpush
