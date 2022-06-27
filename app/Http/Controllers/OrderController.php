<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Order;
use App\OrderDetail;
use App\Setting;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables ;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function show($id)
    {
        $order = Order::with('customer')->where('id', $id)->first();
        //return $order;
        $order_details = DB::table("order_details")
          ->select("order_details.*","products.name","products.code","product_variants.variant", "product_variants.color","product_variants.size")
          ->join("products","products.id","=","order_details.product_id")
          ->join("product_variants","product_variants.id","=","order_details.variant_id")
          ->where('order_details.order_id', $id)->get();
        //return $order_details;
        $company = Setting::latest()->first();
        return view('admin.order.order_confirmation', compact('order_details', 'order', 'company'));
    }
    public function getDatatableDetailed(Request $request)
    {

      $dateto = $request->post("dateto");
      $datefrom = $request->post("datefrom");
      // $products = DB::select("select products.*, a.name as category, b.name as customer from products, categories as a, customers as b where a.id = products.category_id and b.id = products.customer_id ");
      $delURL = url('/') . '/admin/order/destroy/';
      $ediURL = url('/') . '/admin/order/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $orders = DB::table('orders')
          ->join('order_details', 'orders.id', '=', 'order_details.order_id')
          ->join('products', 'order_details.product_id', '=', 'products.id')
          ->join('product_variants', 'order_details.variant_id', '=', 'product_variants.id')
          ->join('customers', 'orders.customer_id', '=', 'customers.id')
          ->select('orders.order_date','customers.name as customer', 'products.image', 'products.code', 'order_details.*',
            DB::raw("concat(products.name,' ',product_variants.variant,' ',
            product_variants.color,' ',product_variants.size) as product_name"),
            DB::raw('concat("row_",orders.id) as DT_RowId'),
            DB::raw('concat("IMS",date_format(orders.order_date,"%Y%m%d"), orders.id) as invoiceno'))
          ->where('orders.order_date' , '>=', $datefrom)
          ->where('orders.order_date' , '<=', $dateto)
          ->orderBy('orders.id', 'desc')
          ->get();

        return Datatables::of($orders)

         ->make(true);


    }
    public function getDatatable(Request $request)
    {
      // $today = date('Y-m-d');
      $dateto = $request->post("dateto");
      $datefrom = $request->post("datefrom");
      // $products = DB::select("select products.*, a.name as category, b.name as customer from products, categories as a, customers as b where a.id = products.category_id and b.id = products.customer_id ");
      $delURL = url('/') . '/admin/order/destroy/';
      $ediURL = url('/') . '/admin/order/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $orders =   DB::table('orders' )
          ->select('orders.*','customers.name as customer',
                DB::raw('concat("row_",orders.id) as DT_RowId'),
                DB::raw('concat("IMS",date_format(orders.order_date,"%Y%m%d"), orders.id) as invoiceno'))
          ->join('customers', 'customers.id', '=', 'orders.customer_id')
          ->where('orders.order_date' , '>=', $datefrom)
          ->where('orders.order_date' , '<=', $dateto)
          ->get();
        return Datatables::of($orders)->make(true);





    }
    public function getDropdownSelect($customer_id)
    {
      $search = $_GET['q'];
      $orders =   DB::table('orders' )
          ->select('*', DB::raw('concat("IMS",date_format(order_date,"%Y%m%d"), id) as invoiceno'))
          ->where('customer_id', '=', $customer_id)
          ->where('balance', '>', '0')
          ->get();
          return json_encode($orders);

    }

    public function pending_order()
    {
        $pendings = Order::latest()->with('customer')->where('order_status', 'pending')->get();
        return view('admin.order.pending_orders', compact('pendings'));
    }

    public function approved_order()
    {
        $approveds = Order::latest()->with('customer')->where('order_status', 'approved')->get();
        return view('admin.order.approved_orders', compact('approveds'));
    }

    public function order_confirm($id)
    {
        $order = Order::findOrFail($id);
        $order->order_status = 'approved';
        $order->save();

        Toastr::success('Order has been Approved! Please delivery the products', 'Success');
        return redirect()->back();
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        Toastr::success('Order has been deleted', 'Success');
        return redirect()->back();
    }

    public function download($order_id)
    {
        $order = Order::with('customer')->where('id', $order_id)->first();
        //return $order;
        // $order_details = OrderDetail::with('product')->where('order_id', $order_id)->get();
        $order_details = DB::table("order_details")
          ->select("order_details.*","products.name","products.code","product_variants.variant", "product_variants.color","product_variants.size")
          ->join("products","products.id","=","order_details.product_id")
          ->join("product_variants","product_variants.id","=","order_details.variant_id")
          ->where('order_details.order_id', $order_id)->get();
        //return $order_details;
        $company = Setting::latest()->first();

        set_time_limit(300);

        $pdf = PDF::loadView('admin.order.pdf', ['order'=>$order, 'order_details'=> $order_details, 'company'=> $company]);

        $content = $pdf->download()->getOriginalContent();

        Storage::put('public/pdf/'.$order->customer->name .'-'. str_pad($order->id,9,"0",STR_PAD_LEFT). '.pdf' ,$content) ;

        Toastr::success('PDF successfully saved', 'Success');
        return redirect()->back();

    }

    // for sales report
    public function todaySales()
    {
        $today = date('Y-m-d');


        return view('admin.sales.today',['today'=>$today] );
    }
    public function todaySalesDetailed($today)
    {

        return view('admin.sales.todaydetailed',['today'=>$today] );
    }

    public function monthly_sales($month = null)
    {
        $today = date('m-d-Y');


        return view('admin.sales.month', ['today'=>$today] );
    }
    public function monthSalesDetailed($today)
    {
        return view('admin.sales.monthdetailed',['today'=>$today] );
    }
    public function getDatatableMonthDetailed(Request $request)
    {

      $dateto = $request->post("dateto");
      $datefrom = $request->post("datefrom");
      $myir = substr($dateto,6,10);
      // $products = DB::select("select products.*, a.name as category, b.name as customer from products, categories as a, customers as b where a.id = products.category_id and b.id = products.customer_id ");
      $delURL = url('/') . '/admin/order/destroy/';
      $ediURL = url('/') . '/admin/order/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $orders = DB::table('orders')
          ->join('order_details', 'orders.id', '=', 'order_details.order_id')
          ->join('products', 'order_details.product_id', '=', 'products.id')
          ->join('product_variants', 'order_details.variant_id', '=', 'product_variants.id')
          ->join('customers', 'orders.customer_id', '=', 'customers.id')
          ->select('orders.order_date','customers.name as customer', 'products.image', 'products.code', 'order_details.*',
            DB::raw("concat(products.name,' ',product_variants.variant,' ',
            product_variants.color,' ',product_variants.size) as product_name"),
            DB::raw('concat("row_",orders.id) as DT_RowId'),
            DB::raw('concat("IMS",date_format(orders.order_date,"%Y%m%d"), orders.id) as invoiceno'))
            ->whereMonth('orders.order_date' , '=', $dateto)
            ->whereYear('orders.order_date' , '=', $myir)
          // ->where('orders.order_date' , '>=', $datefrom)
          // ->where('orders.order_date' , '<=', $dateto)
          ->orderBy('orders.id', 'desc')
          ->get();

        return Datatables::of($orders)

         ->make(true);


    }
    public function getDatatableMonth(Request $request)
    {
      // $dateto  = date('m-d-Y');
      $dateto = $request->post("dateto");

      $datefrom = $request->post("datefrom");
      $myir = substr($dateto,6,10);
      // echo $myir;
      // $products = DB::select("select products.*, a.name as category, b.name as customer from products, categories as a, customers as b where a.id = products.category_id and b.id = products.customer_id ");
      $delURL = url('/') . '/admin/order/destroy/';
      $ediURL = url('/') . '/admin/order/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $orders =   DB::table('orders' )
          ->select('orders.*','customers.name as customer',
                DB::raw('concat("row_",orders.id) as DT_RowId'),
                DB::raw('concat("IMS",date_format(orders.order_date,"%Y%m%d"), orders.id) as invoiceno'))
          ->join('customers', 'customers.id', '=', 'orders.customer_id')
          // ->where('orders.order_date' , '>=', $datefrom)
          // ->where('orders.order_date' , '<=', $dateto)
          ->whereMonth('orders.order_date' , '=', $dateto)
          ->whereYear('orders.order_date' , '=', $myir)
          ->get();
        return Datatables::of($orders)->make(true);





    }

    public function total_sales()
    {
        $today = date('Y-m-d');
        // $balance = Order::all();


        // $orders = DB::table('orders')
        //     ->join('order_details', 'orders.id', '=', 'order_details.order_id')
        //     ->join('products', 'order_details.product_id', '=', 'products.id')
        //     ->join('customers', 'orders.customer_id', '=', 'customers.id')
        //     ->select('customers.name as customer_name', 'products.name AS product_name','products.image', 'order_details.*')
        //     ->orderBy('order_details.created_at', 'desc')
        //     ->get();

        return view('admin.sales.year', ['today'=>$today]   );
    }

    public function getDatatableYear(Request $request)
    {
      // $dateto  = date('m-d-Y');

      $myir = $request->post("dateyear");
      // echo $myir;
      // $products = DB::select("select products.*, a.name as category, b.name as customer from products, categories as a, customers as b where a.id = products.category_id and b.id = products.customer_id ");
      $delURL = url('/') . '/admin/order/destroy/';
      $ediURL = url('/') . '/admin/order/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $orders =   DB::table('orders' )
          ->select('orders.*','customers.name as customer',
                DB::raw('concat("row_",orders.id) as DT_RowId'),
                DB::raw('concat("IMS",date_format(orders.order_date,"%Y%m%d"), orders.id) as invoiceno'))
          ->join('customers', 'customers.id', '=', 'orders.customer_id')
          // ->where('orders.order_date' , '>=', $datefrom)
          // ->where('orders.order_date' , '<=', $dateto)

          ->whereYear('orders.order_date' , '=', $myir)
          ->get();
        return Datatables::of($orders)->make(true);





    }
    public function totalSalesDetailed($today)
    {
        return view('admin.sales.yeardetailed',['today'=>$today] );
    }
    public function getDatatableYearDetailed(Request $request)
    {


      $myir = $request->post("dateyear");
      // echo $myir ;
      // $products = DB::select("select products.*, a.name as category, b.name as customer from products, categories as a, customers as b where a.id = products.category_id and b.id = products.customer_id ");
      $delURL = url('/') . '/admin/order/destroy/';
      $ediURL = url('/') . '/admin/order/';
      // if( order_headers.finalized = 1, concat($delURL,order_headers.id) ,"")
      $orders = DB::table('orders')
          ->join('order_details', 'orders.id', '=', 'order_details.order_id')
          ->join('products', 'order_details.product_id', '=', 'products.id')
          ->join('product_variants', 'order_details.variant_id', '=', 'product_variants.id')
          ->join('customers', 'orders.customer_id', '=', 'customers.id')
          ->select('orders.order_date','customers.name as customer', 'products.image', 'products.code', 'order_details.*',
            DB::raw("concat(products.name,' ',product_variants.variant,' ',
            product_variants.color,' ',product_variants.size) as product_name"),
            DB::raw('concat("row_",orders.id) as DT_RowId'),
            DB::raw('concat("IMS",date_format(orders.order_date,"%Y%m%d"), orders.id) as invoiceno'))
            // ->whereMonth('orders.order_date' , '=', $dateto)
            ->whereYear('orders.order_date' , '=', $myir)
          // ->where('orders.order_date' , '>=', $datefrom)
          // ->where('orders.order_date' , '<=', $dateto)
          ->orderBy('orders.id', 'desc')
          ->get();

        return Datatables::of($orders)

         ->make(true);


    }


    public function salesSummaryCustomer()
    {
        $datefrom = date('Y-m-d');
        $dateto = date('Y-m-d');
        $today = date('Y-m-d');

        return view('admin.sales.customer_summary', ['datefrom'=>$datefrom,'dateto'=>$dateto,'today'=>$today]   );
    }

    public function getDatatableCustomer(Request $request)
    {
      // $dateto  = date('m-d-Y');
      $datefrom = $request->post("datefrom");
      $dateto = $request->post("dateto");

      $myir = $request->post("dateyear");
      $orders =   DB::table('orders' )
          ->select('orders.customer_id','customers.name as customer',
                DB::raw('concat("row_",orders.customer_id) as DT_RowId'),

                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="JANUARY",orders.total,0)) AS JAN'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="FEBRUARY",orders.total,0)) AS FEB'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="MARCH",orders.total,0)) AS MAR'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="APRIL",orders.total,0)) AS APR'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="MAY",orders.total,0)) AS MAY'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="JUNE",orders.total,0)) AS JUNE'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="JULY",orders.total,0)) AS JULY'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="AUGUST",orders.total,0)) AS AUG'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="SEPTEMBER",orders.total,0)) AS SEP'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="OCTOBER",orders.total,0)) AS OCT'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="NOVEMBER",orders.total,0)) AS NOV'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="DECEMBER",orders.total,0)) AS DECEM'),
                DB::raw('SUM(orders.total) AS total'),
                DB::raw('MONTHNAME(orders.order_date) as strmonth'))
          ->join('customers', 'customers.id', '=', 'orders.customer_id')
          ->orderBy("customers.name")
          ->orderBy("orders.customer_id")


          ->groupBy("orders.customer_id" )
          // ->where('orders.order_date' , '>=', $datefrom)
          // ->where('orders.order_date' , '<=', $dateto)
          ->whereYear('orders.order_date' , '=', $myir)
        ->get();
        return Datatables::of($orders)->make(true);





    }

    public function salesSummaryProduct()
    {
        $datefrom = date('Y-m-d');
        $dateto = date('Y-m-d');
        $today = date('Y-m-d');

        return view('admin.sales.product_summary', ['datefrom'=>$datefrom,'dateto'=>$dateto,'today'=>$today]   );
    }

    public function getDatatableProduct(Request $request)
    {
      // $dateto  = date('m-d-Y');
      $datefrom = $request->post("datefrom");
      $dateto = $request->post("dateto");

      $myir = $request->post("dateyear");
      $orders =   DB::table('orders' )
          ->select('orders.order_date','order_details.product_id','products.name as product',
                DB::raw('concat("row_",order_details.product_id) as DT_RowId'),

                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="JANUARY",order_details.total,0)) AS JAN'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="FEBRUARY",order_details.total,0)) AS FEB'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="MARCH",order_details.total,0)) AS MAR'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="APRIL",order_details.total,0)) AS APR'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="MAY",order_details.total,0)) AS MAY'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="JUNE",order_details.total,0)) AS JUNE'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="JULY",order_details.total,0)) AS JULY'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="AUGUST",order_details.total,0)) AS AUG'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="SEPTEMBER",order_details.total,0)) AS SEP'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="OCTOBER",order_details.total,0)) AS OCT'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="NOVEMBER",order_details.total,0)) AS NOV'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="DECEMBER",order_details.total,0)) AS DECEM'),
                DB::raw('SUM(order_details.total) AS total'),
                DB::raw('MONTHNAME(orders.order_date) as strmonth'))
          ->join('order_details', 'order_details.order_id', '=', 'orders.id')
          ->join('products', 'products.id', '=', 'order_details.product_id')
          ->orderBy("products.name")
          ->orderBy("order_details.product_id")


          ->groupBy("order_details.product_id" )
          // ->where('orders.order_date' , '>=', $datefrom)
          // ->where('orders.order_date' , '<=', $dateto)
          ->whereYear('orders.order_date' , '=', $myir)
        ->get();
        return Datatables::of($orders)->make(true);





    }

    public function salesSummaryProductQty()
    {
        $datefrom = date('Y-m-d');
        $dateto = date('Y-m-d');
        $today = date('Y-m-d');

        return view('admin.sales.qty_summary', ['datefrom'=>$datefrom,'dateto'=>$dateto,'today'=>$today]   );
    }

    public function getDatatableProductQty(Request $request)
    {
      // $dateto  = date('m-d-Y');
      $datefrom = $request->post("datefrom");
      $dateto = $request->post("dateto");

      $myir = $request->post("dateyear");
      $orders =   DB::table('orders' )
          ->select('orders.order_date','order_details.product_id','products.name as product',
                DB::raw('concat("row_",order_details.product_id) as DT_RowId'),

                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="JANUARY",order_details.qty,0)) AS JAN'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="FEBRUARY",order_details.qty,0)) AS FEB'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="MARCH",order_details.qty,0)) AS MAR'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="APRIL",order_details.qty,0)) AS APR'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="MAY",order_details.qty,0)) AS MAY'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="JUNE",order_details.qty,0)) AS JUNE'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="JULY",order_details.qty,0)) AS JULY'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="AUGUST",order_details.qty,0)) AS AUG'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="SEPTEMBER",order_details.qty,0)) AS SEP'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="OCTOBER",order_details.qty,0)) AS OCT'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="NOVEMBER",order_details.qty,0)) AS NOV'),
                DB::raw('SUM(if(MONTHNAME(orders.order_date) ="DECEMBER",order_details.qty,0)) AS DECEM'),
                DB::raw('SUM(order_details.qty) AS total'),
                DB::raw('MONTHNAME(orders.order_date) as strmonth'))
          ->join('order_details', 'order_details.order_id', '=', 'orders.id')
          ->join('products', 'products.id', '=', 'order_details.product_id')
          ->orderBy("products.name")
          ->orderBy("order_details.product_id")


          ->groupBy("order_details.product_id" )
        ->whereYear('orders.order_date' , '=', $myir)
        ->get();
        return Datatables::of($orders)->make(true);

    }
}
