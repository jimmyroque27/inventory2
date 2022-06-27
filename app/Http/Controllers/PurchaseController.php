<?php

namespace App\Http\Controllers;
use App\Supplier;
use App\PurchaseHeader;
use App\PurchaseDetail;
use App\Product;
use App\ProductVariant;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables ;

class PurchaseController extends Controller
{
    //
    public function index()
    {
        $purchaseheaders = PurchaseHeader::latest()->with('supplier')->get();
        return view('admin.purchase.index', compact('purchaseheaders'));
    }

    public function getDatatable()
    {

      // $products = DB::select("select products.*, a.name as category, b.name as supplier from products, categories as a, suppliers as b where a.id = products.category_id and b.id = products.supplier_id ");
      $delURL = url('/') . '/admin/purchase/destroy/';
      $ediURL = url('/') . '/admin/purchase/';
      // if( purchase_headers.finalized = 1, concat($delURL,purchase_headers.id) ,"")
      $purchaseheaders =   DB::table('purchase_headers' )
          ->select('purchase_headers.*','suppliers.name as supplier',
                DB::raw('(CASE WHEN purchase_headers.finalized = 0 THEN concat("'.$delURL.'",purchase_headers.id)
                        ELSE ""
                        END) AS delete_url'),
                DB::raw('(CASE WHEN purchase_headers.finalized = 0 THEN concat("'.$ediURL.'",purchase_headers.id,"/edit")
                        ELSE ""
                        END) AS edit_url'))
          ->join('suppliers', 'suppliers.id', '=', 'purchase_headers.supplier_id')
          ->get();


        return Datatables::of($purchaseheaders)
         ->addColumn('actions', function($record){
           return view('includes._datatable_actions', [
               'showUrl'    => route('admin.purchase.show', [ $record->id] ),
               'deleteUrl'  => $record->delete_url,
               'editUrl'    => $record->edit_url,
               // 'deleteUrl' => route('admin.purchase.destroy', [ $record->id]),
               // 'editUrl' => route('admin.purchase.edit', [ $record->id])
           ]);
         })->make(true);





    }
    public function getProductDatatable($id)
    {

      // $products = DB::select("select products.*, a.name as category, b.name as supplier from products, categories as a, suppliers as b where a.id = products.category_id and b.id = products.supplier_id ");
      $purchasedetails =   DB::table('purchase_details' )
          ->select('purchase_details.*', 'products.name','products.code','product_variants.variant','product_variants.color','product_variants.size',  'purchase_details.id as DT_RowId')
          ->join('products', 'products.id', '=', 'purchase_details.product_id')
          ->join('product_variants', 'product_variants.id', '=', 'purchase_details.variant_id')
          ->where('purchase_details.purchase_id', '=', $id)

          ->get();
      return Datatables::of($purchasedetails)
       ->addColumn('actions', function($record){

           return view('includes._datatable_actions', [
                 // 'showUrl' => route('admin.purchase.show', [ $record->id]),
                 'deleteUrl' => route('admin.purchase.product.destroy', [ $record->id]),
                 'editPurchaseItem' =>  $record->id // route('admin.purchase.product.edit', [ $record->id])
           ]);
      })->make(true);




    }
    public function getDropdownSelect($supplier_id)
    {
      $search = $_GET['q'];
      $purchaseheaders =   DB::table('purchase_headers' )
          ->select('id','purchase_date','due_date as puchase_duedate','balance', DB::raw('concat("RR",date_format(purchase_date,"%Y%m%d"), id) as purchaseno'))
          ->where('supplier_id', '=', $supplier_id)
          ->where('balance', '>', '0')
          ->get();
          return json_encode($purchaseheaders);

    }

    public function show($id)
    {

        $purchaseheader = PurchaseHeader::find($id);
        return view('admin.purchase.show', compact('purchaseheader'));
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();
        return view('admin.purchase.create', compact('products', 'suppliers'));
    }

    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
            'supplier_id' => 'required',
            'product_id' => 'required',
            'variant_id' => 'required',
        ];
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Header : Store data in your database table
          $purchaseheader = new PurchaseHeader();
          $purchaseheader->supplier_id = $request->input('supplier_id');
          $purchaseheader->refno = $request->input('refno');
          $purchaseheader->purchase_date = $request->input('purchase_date');
          $purchaseheader->due_date = $request->input('due_date');
          $purchaseheader->save();

        // Details : Store data in your database table
          $purchasedetail = new PurchaseDetail();
          $purchasedetail->purchase_id = $purchaseheader->id;
          $purchasedetail->product_id = $request->input('product_id');
          $purchasedetail->variant_id = $request->input('variant_id');
          $purchasedetail->qty = $request->input('qty');
          $purchasedetail->purchase_price = $request->input('purchase_price');
          $purchasedetail->discount = $request->input('discount');
          $purchasedetail->amount = $request->input('total');
          $purchasedetail->save();

        // Update Product Onhand

          $productvariant = new ProductVariant; //::find($request->input('variant_id'));
          $productvariant->updateLatestQty($request->input('variant_id'));


        // Update Product Onhand

          $purchaseheader->total = ($purchaseheader->total + $request->input('total'));
          $purchaseheader->save();

        // update supplier balance
        $supplier = new Supplier; //::find($request->input('variant_id'));
        $supplier->updateLatestBalance($request->input('supplier_id'));


        Toastr::success('Purchase successfully created', 'Success');
         return redirect()->route('admin.purchase.show',$purchaseheader);

    }
    public function storeNote(Request $request, $id)
    {
        $purchaseheader = PurchaseHeader::find($id);
        $inputs = $request->except('_token');
        $rules = [
            'purchase_status' => 'max:190',

        ];

        $purchaseheader->purchase_status = $request->input('purchase_status');
        $purchaseheader->save();
        Toastr::success('Purchase Note successfully updated', 'Success');

        return view('admin.purchase.show', compact('purchaseheader'));
    }

    public function storeProduct(Request $request)
    {
      $inputs = $request->except('_token');
      $rules = [
          'purchase_id' => 'required',
          'product_id' => 'required',
          'variant_id' => 'required',
      ];

      $validator = Validator::make($inputs, $rules);
      if ($validator->fails())
      {
          return redirect()->back()->withErrors($validator)->withInput();
      }

      $purchasedetail = new PurchaseDetail();
      $purchasedetail->purchase_id = $request->input('purchase_id');
      $purchasedetail->product_id = $request->input('product_id');
      $purchasedetail->variant_id = $request->input('variant_id');
      $purchasedetail->qty = $request->input('qty');
      $purchasedetail->purchase_price = $request->input('purchase_price');
      $purchasedetail->discount = $request->input('discount');
      //$purchasedetail->amount = str_replace(",","",$request->input('amount'));

      $purchasedetail->amount = $request->input('total');
      $purchasedetail->save();

      // Update Product Onhand

      $productvariant = new ProductVariant; //::find($request->input('variant_id'));
      $productvariant->updateLatestQty($request->input('variant_id'));


      // Update Product Onhand


      // $ph_total =   DB::table('purchase_headers' )
      //     ->select('total', 'suppliers.name as supplier')
      //     ->join('suppliers', 'suppliers.id', '=', 'purchase_headers.supplier_id')
      //     ->get();

      $purchaseheader = PurchaseHeader::find($request->input('purchase_id'));
      $old_total = $purchaseheader->total;
      $purchaseheader->total = ($purchaseheader->total + $request->input('total'));
      $purchaseheader->save();

      // update supplier balance
      $supplier = new Supplier; //::find($request->input('variant_id'));
      $supplier->updateLatestBalance($purchaseheader->supplier_id);


      Toastr::success('Purchase Product Addess successfully!!!', 'Success');
       return redirect()->route('admin.purchase.show',$purchaseheader);

    }
    public function edit($id)
    {
        $purchaseheader = PurchaseHeader::find($id);
        return view('admin.purchase.edit', compact('purchaseheader'));
    }

    public function update(Request $request, $id)
    {
      $inputs = $request->except('_token');


      $rules = [
          'supplier_id' => 'required',
          'purchase_status' => 'max:190',
      ];

      $validator = Validator::make($inputs, $rules);
      if ($validator->fails())
      {
          return redirect()->back()->withErrors($validator)->withInput();
      }
      $purchaseheader = PurchaseHeader::find($id);
      $old_total = $purchaseheader->total;
      $old_supplier_id = $purchaseheader->supplier_id;


      $purchaseheader->supplier_id = $request->input('supplier_id');
      $purchaseheader->refno = $request->input('refno');
      $purchaseheader->purchase_date = $request->input('purchase_date');
      $purchaseheader->due_date = $request->input('due_date');
      $purchaseheader->due_date = $request->input('due_date');
      $purchaseheader->purchase_status = $request->input('purchase_status');
      $purchaseheader->save();

      $purchaseheader->total = ($purchaseheader->total + $request->input('total'));
      $purchaseheader->save();
      // update supplier balance
      $supplier = new Supplier; //::find($request->input('variant_id'));
      $supplier->updateLatestBalance($request->input('supplier_id'));


      // update old supplier balance
      if ($purchaseheader->supplier_id != $old_supplier_id){

        // update supplier balance
        $supplier = new Supplier; //::find($request->input('variant_id'));
        $supplier->updateLatestBalance($old_supplier_id);

      }
      Toastr::success('Purchase successfully created', 'Success');
       return redirect()->route('admin.purchase.show',$purchaseheader);

    }
    public function updateFinalized( $id)
    {
        $purchaseheader = PurchaseHeader::find($id);
        $purchaseheader->finalized = 1;
        $purchaseheader->finalized_date = date("Y-m-d");
        $purchaseheader->save();
        Toastr::success('Purchase Status successfully Finalized!!!', 'Success');

        return view('admin.purchase.show', compact('purchaseheader'));
    }

    public function updateProduct(Request $request)
    {
      $inputs = $request->except('_token');


      $rules = [
        'id2' => 'required' ,
        'purchase_id2' => 'required'
      ];

      $validator = Validator::make($inputs, $rules);
      if ($validator->fails())
      {
          return redirect()->back()->withErrors($validator)->withInput();
      }

      $purchasedetail = PurchaseDetail::find($request->input('id2'));

      $variant_id = $purchasedetail->variant_id;
      $purchasedetail->qty = $request->input('qty2');
      $purchasedetail->purchase_price = $request->input('purchase_price2');
      $purchasedetail->discount = $request->input('discount2');
      $purchasedetail->amount = $request->input('total2');
      $purchasedetail->save();

      // Update Product Onhand

      $productvariant = new ProductVariant; //::find($request->input('variant_id'));
      $productvariant->updateLatestQty($variant_id);


      $purchaseheader = PurchaseHeader::find($request->input('purchase_id2'));
      $purchaseheader->total = PurchaseController::getTotalPurchase($request->input('purchase_id2'));
      $purchaseheader->save();
      // update supplier balance
      $supplier = new Supplier; //::find($request->input('variant_id'));
      $supplier->updateLatestBalance($purchaseheader->supplier_id);

      Toastr::success('Purchase successfully created', 'Success');
      return redirect()->route('admin.purchase.show',$purchaseheader);

    }
    public function destroyProduct($id)
    {
      $purchasedetail = PurchaseDetail::find($id);
      $purchase_id = $purchasedetail->purchase_id;
      $variant_id = $purchasedetail->variant_id;
      $purchasedetail->delete();

      // Update Product Onhand

      $productvariant = new ProductVariant; //::find($request->input('variant_id'));
      $productvariant->updateLatestQty($variant_id);


      $purchaseheader = PurchaseHeader::find($purchase_id);
      $purchaseheader->total = PurchaseController::getTotalPurchase($purchase_id);
      $purchaseheader->save();
      // update supplier balance
      $supplier = new Supplier; //::find($request->input('variant_id'));
      $supplier->updateLatestBalance($purchaseheader->supplier_id);

      Toastr::success('Purchase successfully created', 'Success');
      return redirect()->route('admin.purchase.show',$purchaseheader);

    }
    public function destroy($id)
    {
        $purchaseheader = PurchaseHeader::find($id);
        $old_total = $purchaseheader->total;
        $old_supplier_id = $purchaseheader->supplier_id;

        $purchasedetails =   DB::table('purchase_details' )
            ->where('purchase_details.purchase_id', '=', $id)
            ->get();

         foreach($purchasedetails as $purchasedetail){
           $purchase_detail = PurchaseDetail::find($purchasedetail->id);
           $variant_id = $purchase_detail->variant_id;
           $purchase_detail->delete();
           // Update Product Onhand

             $productvariant = new ProductVariant; //::find($request->input('variant_id'));
             $productvariant->updateLatestQty($variant_id);


           // Update Product Onhand

         }
         // update supplier balance
         $supplier = new Supplier; //::find($request->input('variant_id'));
         $supplier->updateLatestBalance($old_supplier_id);

        $purchaseheader->delete();
        Toastr::success('Purchase successfully deleted', 'Success');
         return redirect()->route('admin.purchase.index');

    }
    public function getTotalPerSupplier($id)
    {
      $purchaseheaders = PurchaseHeader::select("purchase_headers.*", DB::raw('SUM(total) as sum_amount'))
        ->where('supplier_id','=',$id)
        ->groupBy('supplier_id')
        ->get();

        $totalsum = 0;
        foreach ( $purchaseheaders  as $purchaseheader ){
            $totalsum = $purchaseheader->sum_amount;
        }
        return $totalsum;
    }
    public function getTotalPurchase($id)
    {
      $purchasedetails =   DB::table('purchase_details' )
        ->select("purchase_details.*", DB::raw('SUM(purchase_details.amount) as sum_amount'))
        ->where('purchase_details.purchase_id','=',$id)
        ->groupBy('purchase_details.purchase_id')
        ->get();
        $totalsum = 0;
        foreach ( $purchasedetails  as $purchasedetail ){
            $totalsum = $purchasedetail->sum_amount;
        }
        return $totalsum;
    }
    public function getTotalPerProduct($id)
    {
      $purchasedetails =   DB::table('purchase_details' )
        ->select("purchase_details.*", DB::raw('SUM(purchase_details.amount) as sum_amount'))
        ->where('purchase_details.product_id','=',$id)
        ->groupBy('purchase_details.product_id')
        ->get();
        $totalsum = 0;
        foreach ( $purchasedetails  as $purchasedetail ){
            $totalsum = $purchasedetail->sum_amount;
        }
        return $totalsum;
    }
    public function getQtyPerProduct($id)
    {
      $purchasedetails =   DB::table('purchase_details' )
        ->select("purchase_details.*", DB::raw('SUM(purchase_details.qty) as sum_qty'))
        ->where('purchase_details.product_id','=',$id)
        ->groupBy('purchase_details.product_id')
        ->get();
        $totalsum = 0;
        foreach ( $purchasedetails  as $purchasedetail ){
            $totalsum = $purchasedetail->sum_qty;
        }
        return $totalsum;
    }
    public function getQtyPerVariant($id)
    {
      $purchasedetails =   DB::table('purchase_details' )
        ->select("purchase_details.*", DB::raw('SUM(purchase_details.qty) as sum_qty'))
        ->where('purchase_details.variant_id','=',$id)
        ->groupBy('purchase_details.variant_id')
        ->get();
        $totalsum = 0;
        foreach ( $purchasedetails  as $purchasedetail ){
            $totalsum = $purchasedetail->sum_qty;
        }
        return $totalsum;
    }

}
