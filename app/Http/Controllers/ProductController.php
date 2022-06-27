<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
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
class ProductController extends Controller
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
        $products = Product::latest()->with('category', 'supplier')->get();
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.product.create', compact('categories', 'suppliers'));
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
         // ->addColumn('asupplier', function($products){
         //     return view('includes._datatable_actions', [
         //       'colUrl' => route('admin.supplier.show', [ $products->supplier_id]),
         //       'colVal' =>    $products->supplier
         //     ]);
         // })
         ->addColumn('onhand', function($products){

           $variants =   DB::table('product_variants' )
              ->select('product_variants.*', DB::raw('SUM(onhand) AS sumonhand') )
              ->where('product_variants.product_id','=', $products->id)

              ->get();
             $qtyonhand = 0;
           foreach($variants as  $variant)
           {
              $qtyonhand += $variant->sumonhand;
           }
             return  $qtyonhand;
         })

         ->addColumn('actions', function($record){
           return view('includes._datatable_actions', [
               'showUrl'    => route('admin.product.show', [ $record->id] ),
               // 'deleteUrl'  => $record->delete_url,
               // 'editUrl'    => $record->edit_url,
               'deleteUrl' => route('admin.product.destroy', [ $record->id]),
               'editUrl' => route('admin.product.edit', [ $record->id])
           ]);
         })
         ->make(true);





    }

    public function getDropdownSelect()
    {
      $search = $_GET['q'];
      $products =   DB::table('products' )
          ->select('name','code','id','image')
          ->where('name', 'LIKE', '%'.$search.'%')
          ->orWhere('code', 'LIKE', '%'.$search.'%')

          ->get();
          return json_encode($products);

    }
    public function getVariantDatatable($product_id)
    {
      $variants =   DB::table('product_variants' )
         ->where('product_id','=', $product_id)
         ->get();

       return Datatables::of($variants)
         ->addColumn('actions', function($variants){
             return view('includes._datatable_actions', [
                 'addUrl' => route('admin.product.variant.create',[$variants->product_id]),
                 'deleteUrl' => route('admin.product.variant.destroy', [ $variants->id]),
                 'editUrl' => route('admin.product.variant.edit', [ $variants->id])
             ]);
         })
       ->make(true);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
            'name' => 'required | min:3',
            'category_id' => 'required| integer',
            'supplier_id' => 'required | integer',
            'code' => 'required',
            'garage' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'route' => 'required',
            'buying_date' => 'required | date',
            'expire_date' => 'date',
            'buying_price' => 'required',
            'selling_price' => 'required',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('image');
        $slug =  Str::slug($request->input('code'));
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug. '.'.$image->getClientOriginalExtension();
            if (!Storage::disk('product_upload'))
            {
                Storage::disk('product_upload')->makeDirectory(path());

            }

            // delete old photo
            if (Storage::disk('product_upload')->exists(  $imageName))
            {

                Storage::disk('product_upload')->delete(  $imageName);
            }

            $postImage = Image::make($image)->resize(480, 320)->stream();
            Storage::disk('product_upload')->put($imageName, $postImage);
        } else
        {
            $imageName = 'default.png';
        }

        $product = new Product();
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->supplier_id = $request->input('supplier_id');
        $product->code = $request->input('code');
        $product->garage = $request->input('garage');
        $product->route = $request->input('route');
        $product->buying_date = $request->input('buying_date');
        $product->expire_date = $request->input('expire_date');
        $product->buying_price = $request->input('buying_price');
        $product->selling_price = $request->input('selling_price');
        $product->image = $imageName;
        $product->save();

        Toastr::success('Product Successfully Created', 'Success!!!');

        return redirect()->route('admin.product.show',compact('product'));
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
    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        return view('admin.product.edit', compact('product', 'categories', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $inputs = $request->except('_token');
        $rules = [
            'name' => 'required | min:3',
            'category_id' => 'required| integer',
            'supplier_id' => 'required | integer',
            'code' => 'required',
            'garage' => 'required',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'route' => 'required',
            'buying_date' => 'nullable | date',
            'expire_date' => 'nullable | date',
            'buying_price' => 'required',
            'selling_price' => 'required',
        ];

        $validation = Validator::make($inputs, $rules);
        if ($validation->fails())
        {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $image = $request->file('image');
        $slug =  Str::slug($request->input('code'));
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imageName = $slug .  '.'.$image->getClientOriginalExtension();
            if (!Storage::disk('product_upload'))
            {
                Storage::disk('product_upload')->makeDirectory(path());

            }

            // delete old photo
            if (Storage::disk('product_upload')->exists(  $product->image))
            {

                Storage::disk('product_upload')->delete(  $product->image);
            }

            $postImage = Image::make($image)->resize(480, 320)->stream();
            Storage::disk('product_upload')->put($imageName, $postImage);
        } else
        {
            $imageName = $product->image;
        }

        $buying_date = $request->input('buying_date');
        if (!isset($buying_date))
        {
            $buying_date = $product->buying_date;
        }

        $expire_date = $request->input('expire_date');
        if (!isset($expire_date))
        {
            $expire_date = $product->expire_date;
        }

        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->supplier_id = $request->input('supplier_id');
        $product->code = $request->input('code');
        $product->garage = $request->input('garage');
        $product->route = $request->input('route');
        $product->buying_date = $buying_date;
        $product->expire_date = $expire_date;
        $product->buying_price = $request->input('buying_price');
        $product->selling_price = $request->input('selling_price');
        $product->image = $imageName;
        $product->save();

        Toastr::success('Product Successfully Updated', 'Success!!!');
        return redirect()->route('admin.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        // delete old photo
        if (Storage::disk('product_upload')->exists($product->image))
        {
            Storage::disk('product_upload')->delete($product->image);
        }

        $product->delete();
        Toastr::success('Product Successfully Deleted', 'Success!!!');
        return redirect()->route('admin.product.index');
    }
}
