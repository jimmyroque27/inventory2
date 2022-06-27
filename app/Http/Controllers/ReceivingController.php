<?php

namespace App\Http\Controllers;

use App\Expense;
use App\PurchaseHeader;
use App\PurchaseDetail;
use App\Setting;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables ;
use Illuminate\Http\Request;

class ReceivingController extends Controller
{

    public function show($id)
    {

    }
    public function getDatatableDetailed(Request $request)
    {

      $dateto = $request->post("dateto");
      $datefrom = $request->post("datefrom");
      // $products = DB::select("select products.*, a.name as category, b.name as supplier from products, categories as a, suppliers as b where a.id = products.category_id and b.id = products.supplier_id ");
      $delURL = url('/') . '/admin/receiving/destroy/';
      $ediURL = url('/') . '/admin/receiving/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $purchaseheaders = DB::table('purchase_headers')
          ->join('purchase_details', 'purchase_headers.id', '=', 'purchase_details.purchase_id')
          ->join('products', 'purchase_details.product_id', '=', 'products.id')
          ->join('product_variants', 'purchase_details.variant_id', '=', 'product_variants.id')
          ->join('suppliers', 'purchase_headers.supplier_id', '=', 'suppliers.id')
          ->select('purchase_headers.purchase_date','suppliers.name as supplier', 'products.image', 'products.code', 'purchase_details.*',
            DB::raw("concat(products.name,' ',product_variants.variant,' ',
            product_variants.color,' ',product_variants.size) as product_name"),
            DB::raw('concat("row_",purchase_headers.id) as DT_RowId'),
            DB::raw('concat("RR",date_format(purchase_headers.purchase_date,"%Y%m%d"), purchase_headers.id) as invoiceno'))
          ->where('purchase_headers.purchase_date' , '>=', $datefrom)
          ->where('purchase_headers.purchase_date' , '<=', $dateto)
          ->orderBy('purchase_headers.id', 'desc')
          ->get();

        return Datatables::of($purchaseheaders)

         ->make(true);


    }
    public function getDatatable(Request $request)
    {
      // $today = date('Y-m-d');
      $dateto = $request->post("dateto");
      $datefrom = $request->post("datefrom");
      // $products = DB::select("select products.*, a.name as category, b.name as supplier from products, categories as a, suppliers as b where a.id = products.category_id and b.id = products.supplier_id ");
      $delURL = url('/') . '/admin/receiving/destroy/';
      $ediURL = url('/') . '/admin/receiving/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $purchaseheaders =   DB::table('purchase_headers' )
          ->select('purchase_headers.*','suppliers.name as supplier',
                DB::raw('concat("row_",purchase_headers.id) as DT_RowId'),
                DB::raw('concat("RR",date_format(purchase_headers.purchase_date,"%Y%m%d"), purchase_headers.id) as invoiceno'))
          ->join('suppliers', 'suppliers.id', '=', 'purchase_headers.supplier_id')
          ->where('purchase_headers.purchase_date' , '>=', $datefrom)
          ->where('purchase_headers.purchase_date' , '<=', $dateto)
          ->get();
        return Datatables::of($purchaseheaders)->make(true);





    }
    public function getDropdownSelect($supplier_id)
    {
      $search = $_GET['q'];
      $purchaseheaders =   DB::table('purchase_headers' )
          ->select('*', DB::raw('concat("RR",date_format(purchase_date,"%Y%m%d"), id) as invoiceno'))
          ->where('supplier_id', '=', $supplier_id)
          ->where('balance', '>', '0')
          ->get();
          return json_encode($purchaseheaders);

    }





    public function destroy($id)
    {


    }

    public function download($purchaseheader_id)
    {


    }

    // for receiving report
    public function todayPurchases()
    {
        $today = date('Y-m-d');


        return view('admin.receiving.today',['today'=>$today] );
    }
    public function todayPurchasesDetailed($today)
    {

        return view('admin.receiving.todaydetailed',['today'=>$today] );
    }

    public function monthly_receiving($month = null)
    {
        $today = date('m-d-Y');


        return view('admin.receiving.month', ['today'=>$today] );
    }
    public function monthPurchasesDetailed($today)
    {
        return view('admin.receiving.monthdetailed',['today'=>$today] );
    }
    public function getDatatableMonthDetailed(Request $request)
    {

      $dateto = $request->post("dateto");
      $datefrom = $request->post("datefrom");
      $myir = substr($dateto,6,10);
      // $products = DB::select("select products.*, a.name as category, b.name as supplier from products, categories as a, suppliers as b where a.id = products.category_id and b.id = products.supplier_id ");
      $delURL = url('/') . '/admin/receiving/destroy/';
      $ediURL = url('/') . '/admin/receiving/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $purchaseheaders = DB::table('purchase_headers')
          ->join('purchase_details', 'purchase_headers.id', '=', 'purchase_details.purchase_id')
          ->join('products', 'purchase_details.product_id', '=', 'products.id')
          ->join('product_variants', 'purchase_details.variant_id', '=', 'product_variants.id')
          ->join('suppliers', 'purchase_headers.supplier_id', '=', 'suppliers.id')
          ->select('purchase_headers.purchase_date','suppliers.name as supplier', 'products.image', 'products.code', 'purchase_details.*',
            DB::raw("concat(products.name,' ',product_variants.variant,' ',
            product_variants.color,' ',product_variants.size) as product_name"),
            DB::raw('concat("row_",purchase_headers.id) as DT_RowId'),
            DB::raw('concat("RR",date_format(purchase_headers.purchase_date,"%Y%m%d"), purchase_headers.id) as invoiceno'))
            ->whereMonth('purchase_headers.purchase_date' , '=', $dateto)
            ->whereYear('purchase_headers.purchase_date' , '=', $myir)
          // ->where('purchase_headers.purchase_date' , '>=', $datefrom)
          // ->where('purchase_headers.purchase_date' , '<=', $dateto)
          ->orderBy('purchase_headers.id', 'desc')
          ->get();

        return Datatables::of($purchaseheaders)

         ->make(true);


    }
    public function getDatatableMonth(Request $request)
    {
      // $dateto  = date('m-d-Y');
      $dateto = $request->post("dateto");

      $datefrom = $request->post("datefrom");
      $myir = substr($dateto,6,10);
      // echo $myir;
      // $products = DB::select("select products.*, a.name as category, b.name as supplier from products, categories as a, suppliers as b where a.id = products.category_id and b.id = products.supplier_id ");
      $delURL = url('/') . '/admin/receiving/destroy/';
      $ediURL = url('/') . '/admin/receiving/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $purchaseheaders =   DB::table('purchase_headers' )
          ->select('purchase_headers.*','suppliers.name as supplier',
                DB::raw('concat("row_",purchase_headers.id) as DT_RowId'),
                DB::raw('concat("RR",date_format(purchase_headers.purchase_date,"%Y%m%d"), purchase_headers.id) as invoiceno'))
          ->join('suppliers', 'suppliers.id', '=', 'purchase_headers.supplier_id')
          // ->where('purchase_headers.purchase_date' , '>=', $datefrom)
          // ->where('purchase_headers.purchase_date' , '<=', $dateto)
          ->whereMonth('purchase_headers.purchase_date' , '=', $dateto)
          ->whereYear('purchase_headers.purchase_date' , '=', $myir)
          ->get();
        return Datatables::of($purchaseheaders)->make(true);





    }

    public function total_receiving()
    {
        $today = date('Y-m-d');
        // $balance = Order::all();


        // $purchaseheaders = DB::table('purchase_headers')
        //     ->join('purchase_details', 'purchase_headers.id', '=', 'purchase_details.purchase_id')
        //     ->join('products', 'purchase_details.product_id', '=', 'products.id')
        //     ->join('suppliers', 'purchase_headers.supplier_id', '=', 'suppliers.id')
        //     ->select('suppliers.name as supplier_name', 'products.name AS product_name','products.image', 'purchase_details.*')
        //     ->orderBy('purchase_details.created_at', 'desc')
        //     ->get();

        return view('admin.receiving.year', ['today'=>$today]   );
    }

    public function getDatatableYear(Request $request)
    {
      // $dateto  = date('m-d-Y');

      $myir = $request->post("dateyear");
      // echo $myir;
      // $products = DB::select("select products.*, a.name as category, b.name as supplier from products, categories as a, suppliers as b where a.id = products.category_id and b.id = products.supplier_id ");
      $delURL = url('/') . '/admin/receiving/destroy/';
      $ediURL = url('/') . '/admin/receiving/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $purchaseheaders =   DB::table('purchase_headers' )
          ->select('purchase_headers.*','suppliers.name as supplier',
                DB::raw('concat("row_",purchase_headers.id) as DT_RowId'),
                DB::raw('concat("RR",date_format(purchase_headers.purchase_date,"%Y%m%d"), purchase_headers.id) as invoiceno'))
          ->join('suppliers', 'suppliers.id', '=', 'purchase_headers.supplier_id')
          // ->where('purchase_headers.purchase_date' , '>=', $datefrom)
          // ->where('purchase_headers.purchase_date' , '<=', $dateto)

          ->whereYear('purchase_headers.purchase_date' , '=', $myir)
          ->get();
        return Datatables::of($purchaseheaders)->make(true);





    }
    public function totalPurchasesDetailed($today)
    {
        return view('admin.receiving.yeardetailed',['today'=>$today] );
    }
    public function getDatatableYearDetailed(Request $request)
    {


      $myir = $request->post("dateyear");
      // echo $myir ;
      // $products = DB::select("select products.*, a.name as category, b.name as supplier from products, categories as a, suppliers as b where a.id = products.category_id and b.id = products.supplier_id ");
      $delURL = url('/') . '/admin/receiving/destroy/';
      $ediURL = url('/') . '/admin/receiving/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $purchaseheaders = DB::table('purchase_headers')
          ->join('purchase_details', 'purchase_headers.id', '=', 'purchase_details.purchase_id')
          ->join('products', 'purchase_details.product_id', '=', 'products.id')
          ->join('product_variants', 'purchase_details.variant_id', '=', 'product_variants.id')
          ->join('suppliers', 'purchase_headers.supplier_id', '=', 'suppliers.id')
          ->select('purchase_headers.purchase_date','suppliers.name as supplier', 'products.image', 'products.code', 'purchase_details.*',
            DB::raw("concat(products.name,' ',product_variants.variant,' ',
            product_variants.color,' ',product_variants.size) as product_name"),
            DB::raw('concat("row_",purchase_headers.id) as DT_RowId'),
            DB::raw('concat("RR",date_format(purchase_headers.purchase_date,"%Y%m%d"), purchase_headers.id) as invoiceno'))
            // ->whereMonth('purchase_headers.purchase_date' , '=', $dateto)
            ->whereYear('purchase_headers.purchase_date' , '=', $myir)
          // ->where('purchase_headers.purchase_date' , '>=', $datefrom)
          // ->where('purchase_headers.purchase_date' , '<=', $dateto)
          ->orderBy('purchase_headers.id', 'desc')
          ->get();

        return Datatables::of($purchaseheaders)

         ->make(true);


    }


    public function receivingSummarySupplier()
    {
        $datefrom = date('Y-m-d');
        $dateto = date('Y-m-d');
        $today = date('Y-m-d');

        return view('admin.receiving.supplier_summary', ['datefrom'=>$datefrom,'dateto'=>$dateto,'today'=>$today]   );
    }

    public function getDatatableSupplier(Request $request)
    {
      // $dateto  = date('m-d-Y');
      $datefrom = $request->post("datefrom");
      $dateto = $request->post("dateto");

      $myir = $request->post("dateyear");
      $purchaseheaders =   DB::table('purchase_headers' )
          ->select('purchase_headers.supplier_id','suppliers.name as supplier',
                DB::raw('concat("row_",purchase_headers.supplier_id) as DT_RowId'),

                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="JANUARY",purchase_headers.total,0)) AS JAN'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="FEBRUARY",purchase_headers.total,0)) AS FEB'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="MARCH",purchase_headers.total,0)) AS MAR'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="APRIL",purchase_headers.total,0)) AS APR'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="MAY",purchase_headers.total,0)) AS MAY'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="JUNE",purchase_headers.total,0)) AS JUNE'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="JULY",purchase_headers.total,0)) AS JULY'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="AUGUST",purchase_headers.total,0)) AS AUG'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="SEPTEMBER",purchase_headers.total,0)) AS SEP'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="OCTOBER",purchase_headers.total,0)) AS OCT'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="NOVEMBER",purchase_headers.total,0)) AS NOV'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="DECEMBER",purchase_headers.total,0)) AS DECEM'),
                DB::raw('SUM(purchase_headers.total) AS total'),
                DB::raw('MONTHNAME(purchase_headers.purchase_date) as strmonth'))
          ->join('suppliers', 'suppliers.id', '=', 'purchase_headers.supplier_id')
          ->orderBy("suppliers.name")
          ->orderBy("purchase_headers.supplier_id")


          ->groupBy("purchase_headers.supplier_id" )
          // ->where('purchase_headers.purchase_date' , '>=', $datefrom)
          // ->where('purchase_headers.purchase_date' , '<=', $dateto)
          ->whereYear('purchase_headers.purchase_date' , '=', $myir)
        ->get();
        return Datatables::of($purchaseheaders)->make(true);





    }

    public function receivingSummaryProduct()
    {
        $datefrom = date('Y-m-d');
        $dateto = date('Y-m-d');
        $today = date('Y-m-d');

        return view('admin.receiving.product_summary', ['datefrom'=>$datefrom,'dateto'=>$dateto,'today'=>$today]   );
    }

    public function getDatatableProduct(Request $request)
    {
      // $dateto  = date('m-d-Y');
      $datefrom = $request->post("datefrom");
      $dateto = $request->post("dateto");

      $myir = $request->post("dateyear");
      $purchaseheaders =   DB::table('purchase_headers' )
          ->select('purchase_headers.purchase_date','purchase_details.product_id','products.name as product',
                DB::raw('concat("row_",purchase_details.product_id) as DT_RowId'),

                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="JANUARY",purchase_details.amount,0)) AS JAN'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="FEBRUARY",purchase_details.amount,0)) AS FEB'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="MARCH",purchase_details.amount,0)) AS MAR'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="APRIL",purchase_details.amount,0)) AS APR'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="MAY",purchase_details.amount,0)) AS MAY'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="JUNE",purchase_details.amount,0)) AS JUNE'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="JULY",purchase_details.amount,0)) AS JULY'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="AUGUST",purchase_details.amount,0)) AS AUG'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="SEPTEMBER",purchase_details.amount,0)) AS SEP'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="OCTOBER",purchase_details.amount,0)) AS OCT'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="NOVEMBER",purchase_details.amount,0)) AS NOV'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="DECEMBER",purchase_details.amount,0)) AS DECEM'),
                DB::raw('SUM(purchase_details.amount) AS total'),
                DB::raw('MONTHNAME(purchase_headers.purchase_date) as strmonth'))
          ->join('purchase_details', 'purchase_details.purchase_id', '=', 'purchase_headers.id')
          ->join('products', 'products.id', '=', 'purchase_details.product_id')
          ->orderBy("products.name")
          ->orderBy("purchase_details.product_id")


          ->groupBy("purchase_details.product_id" )
          // ->where('purchase_headers.purchase_date' , '>=', $datefrom)
          // ->where('purchase_headers.purchase_date' , '<=', $dateto)
          ->whereYear('purchase_headers.purchase_date' , '=', $myir)
        ->get();
        return Datatables::of($purchaseheaders)->make(true);





    }

    public function receivingSummaryProductQty()
    {
        $datefrom = date('Y-m-d');
        $dateto = date('Y-m-d');
        $today = date('Y-m-d');

        return view('admin.receiving.qty_summary', ['datefrom'=>$datefrom,'dateto'=>$dateto,'today'=>$today]   );
    }

    public function getDatatableProductQty(Request $request)
    {
      // $dateto  = date('m-d-Y');
      $datefrom = $request->post("datefrom");
      $dateto = $request->post("dateto");

      $myir = $request->post("dateyear");
      $purchaseheaders =   DB::table('purchase_headers' )
          ->select('purchase_headers.purchase_date','purchase_details.product_id','products.name as product',
                DB::raw('concat("row_",purchase_details.product_id) as DT_RowId'),

                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="JANUARY",purchase_details.qty,0)) AS JAN'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="FEBRUARY",purchase_details.qty,0)) AS FEB'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="MARCH",purchase_details.qty,0)) AS MAR'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="APRIL",purchase_details.qty,0)) AS APR'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="MAY",purchase_details.qty,0)) AS MAY'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="JUNE",purchase_details.qty,0)) AS JUNE'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="JULY",purchase_details.qty,0)) AS JULY'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="AUGUST",purchase_details.qty,0)) AS AUG'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="SEPTEMBER",purchase_details.qty,0)) AS SEP'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="OCTOBER",purchase_details.qty,0)) AS OCT'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="NOVEMBER",purchase_details.qty,0)) AS NOV'),
                DB::raw('SUM(if(MONTHNAME(purchase_headers.purchase_date) ="DECEMBER",purchase_details.qty,0)) AS DECEM'),
                DB::raw('SUM(purchase_details.qty) AS total'),
                DB::raw('MONTHNAME(purchase_headers.purchase_date) as strmonth'))
          ->join('purchase_details', 'purchase_details.purchase_id', '=', 'purchase_headers.id')
          ->join('products', 'products.id', '=', 'purchase_details.product_id')
          ->orderBy("products.name")
          ->orderBy("purchase_details.product_id")


          ->groupBy("purchase_details.product_id" )
        ->whereYear('purchase_headers.purchase_date' , '=', $myir)
        ->get();
        return Datatables::of($purchaseheaders)->make(true);

    }
}
