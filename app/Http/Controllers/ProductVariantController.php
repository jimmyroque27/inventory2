<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Color;
use App\Size;
use App\ProductVariant;
use App\Supplier;
use Yajra\DataTables\DataTables ;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\ProductRepositoryInterface as ProductRepository;
class ProductVariantController extends Controller
{
    private $productRepository;

    // public function __construct(ProductRepository $productRepository)
    // {
    //     $this->productRepository = $productRepository;
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_variants = ProductVariant::latest()->with('product')->get();
        return view('admin.product.variant.index', compact('product_variants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $product = Product::find($id);
        $colors = Color::all();
        $sizes = Size::all();

        return view('admin.product.variant.create', compact('product', 'colors', 'sizes' ));
    }

    /**
     * Returns data for the resource list
     *
     * @param  integer  unique identifier for the related product resource
     * @return \Illuminate\Http\Response
     */
    public function getDatatable()
    {

      // $products = DB::select("select products.*, a.name as category, b.name as supplier from products, categories as a, suppliers as b where a.id = products.category_id and b.id = products.supplier_id ");

      $products =   DB::table('products' )
          ->select('products.*', 'categories.name as category', 'suppliers.name as supplier')
          ->join('categories', 'categories.id', '=', 'products.category_id')
          ->join('suppliers', 'suppliers.id', '=', 'products.supplier_id')
          ->get();

       return Datatables::of($products)
         ->addColumn('aname', function($products){
             return view('includes._datatable_actions', [
               'colUrl' => route('admin.product.show', [ $products->id]),
               'colVal' =>    $products->name
             ]);
         })
         ->addColumn('acode', function($products){
             return view('includes._datatable_actions', [
               'colUrl' => route('admin.product.show', [ $products->id]),
               'colVal' =>    $products->code
             ]);
         })
         ->addColumn('aimage', function($products){
             return view('includes._datatable_actions', [
               'colImgUrl' => route('admin.product.show', [ $products->id]),
               'colVal' =>    $products->name,
               'colWidth' =>   "35px",
               'colHeight' =>   "35px",
               'colImg' =>    asset('product/'  .$products->image )
             ]);
         })
         ->addColumn('acategory', function($products){
             return view('includes._datatable_actions', [
               'colUrl' => route('admin.category.edit', [ $products->category_id]),
               'colVal' =>    $products->category
             ]);
         })
         ->addColumn('asupplier', function($products){
             return view('includes._datatable_actions', [
               'colUrl' => route('admin.supplier.show', [ $products->supplier_id]),
               'colVal' =>    $products->supplier
             ]);
         })
         ->addColumn('onhand', function($products){

           $variants =   DB::table('product_variants' )
              ->select('product_variants.*', DB::raw('SUM(onhasnd) AS sumonhand') )
              ->where('product_variants.product_id','=', $products->id)

              ->get();
             $qtyonhand = 0;
           foreach($variants as  $variant)
           {
              $qtyonhand += $variant->sumonhand;
           }
             return  $qtyonhand;
         })
         ->make(true);
       //
        /*  ->addColumn('actions', function($record){
              return view('includes._datatable_actions', [

                  'deleteUrl' => route('admin.product.destroy', [ $record->id]),
                  'editUrl' => route('admin.product.edit', [ $record->id])
              ]);
          })
        */


    }


    public function getVariantDatatable($product_id)
    {

      // $products = DB::select("select products.*, a.name as category, b.name as supplier from products, categories as a, suppliers as b where a.id = products.category_id and b.id = products.supplier_id ");

      $variants =   DB::table('product_variants' )
         // ->select('product_variants.*', DB::raw('SUM(onhand) AS sumonhand') )
         ->where('product_variants.product_id','=', $product_id)
         ->get();

       return Datatables::of($variants)
         ->addColumn('actions', function($variants){
             return view('includes._datatable_actions', [
                 'addUrl' => route('admin.product.variant.create', $product_id),
                 'deleteUrl' => route('admin.product.variant.destroy', [ $variants->id]),
                 'editUrl' => route('admin.product.variant.edit', [ $variants->id])
             ]);
         })


       ->make(true);

       //


    }

    public function getDropdownSelect()
    {
      // $search = $_GET['q'];
       $id    = $_GET['id'];
      // $id= 1;
      $products =   DB::table('product_variants' )
          ->select('*')
          ->where('product_id', '=',$id)
          // ->where('onhand', '>',0)
          // ->where('variant', 'LIKE', '%'.$search.'%')
          ->get();

          return json_encode($products);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $inputs = $request->except('_token');
        $rules = [
            'variant' => 'required | min:3',
            'size' => 'required ',
            'color' => 'required ',
            'buying_price' => 'required',
            'selling_price' => 'required',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }



        $productvariant = new ProductVariant();
        $productvariant->product_id = $request->input('product_id');
        $productvariant->variant = $request->input('variant');
        $productvariant->color = $request->input('color');
        $productvariant->size = $request->input('size');

        $productvariant->buying_price = $request->input('buying_price');
        $productvariant->selling_price = $request->input('selling_price');

        $productvariant->save();

        Toastr::success('Product Variant Successfully Created', 'Success!!!');
        return redirect()->route('admin.product.show',$request->input('product_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$productvariant = DB::table('product_variants' )->select("product_variants.*")->where('product_variants.product_id','=',$product_id)->get();
        $productvariant = ProductVariant::find($id);

        $product = Product::find($productvariant->product_id);
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.product.variant.edit', compact('productvariant','product', 'colors', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $inputs = $request->except('_token');
      $rules = [
          'product_id' => 'required',
          'variant' => 'required | min:3',
          'size' => 'required ',
          'color' => 'required ',
          'buying_price' => 'required',
          'selling_price' => 'required',
      ];

      $validation = Validator::make($inputs, $rules);
      if ($validation->fails())
      {
          return redirect()->back()->withErrors($validation)->withInput();
      }



      $productvariant = ProductVariant::find($id);
      $productvariant->variant = $request->input('variant');
      $productvariant->color = $request->input('color');
      $productvariant->size = $request->input('size');
      $productvariant->buying_price = $request->input('buying_price');
      $productvariant->selling_price = $request->input('selling_price');
      $productvariant->save();

      $product = Product::find($request->input('product_id'));

      Toastr::success('Product Variant Successfully Updated', 'Success!!!');
      return redirect()->route('admin.product.show',compact("product"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $productvariant = ProductVariant::find($id);
        $product_id =$productvariant->product_id;
        $productvariant->delete();

        Toastr::success('Product Variant Successfully Deleted', 'Success!!!');
        return redirect()->route('admin.product.show',$product_id);
    }
}
