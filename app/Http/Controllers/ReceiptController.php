<?php

namespace App\Http\Controllers;
use App\Customer;
use App\ReceiptHeader;
use App\ReceiptDetail;
use App\ReceiptInvoice;

use App\Order;
use App\PaymentType;
use App\Merchant;

use App\Product;
use App\ProductVariant;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables ;

class ReceiptController extends Controller
{
    //
    public function index()
    {
        $receiptheaders = ReceiptHeader::latest()->with('customer')->get();
        return view('admin.receipt.index', compact('receiptheaders'));
    }

    public function getDatatable()
    {

      // $products = DB::select("select products.*, a.name as category, b.name as customer from products, categories as a, customers as b where a.id = products.category_id and b.id = products.customer_id ");
      $delURL = url('/') . '/admin/receipt/destroy/';
      $ediURL = url('/') . '/admin/receipt/';
      // if( receipt_headers.finalized = 1, concat($delURL,receipt_headers.id) ,"")
      $receiptheaders =   DB::table('receipt_headers' )
          ->select('receipt_headers.*','customers.name as customer',
                DB::raw('concat("row_",receipt_headers.id) as DT_RowId'),
                DB::raw('(CASE WHEN receipt_headers.finalized = 0 THEN concat("'.$delURL.'",receipt_headers.id)
                        ELSE ""
                        END) AS delete_url'),
                DB::raw('(CASE WHEN receipt_headers.finalized = 0 THEN concat("'.$ediURL.'",receipt_headers.id,"/edit")
                        ELSE ""
                        END) AS edit_url'))
          ->join('customers', 'customers.id', '=', 'receipt_headers.customer_id')
          ->get();


        return Datatables::of($receiptheaders)
         ->addColumn('actions', function($record){
           return view('includes._datatable_actions', [
               'showUrl'    => route('admin.receipt.show', [ $record->id] ),
               'deleteUrl'  => $record->delete_url,
               // 'editUrl'    => $record->edit_url,
                'editPurchaseItem' => $record->id,
               // 'deleteUrl' => route('admin.receipt.destroy', [ $record->id]),
               // 'editUrl' => route('admin.receipt.edit', [ $record->id])
           ]);
         })->make(true);





    }
    public function getDetailsDatatable($id)
    {

      // $products = DB::select("select products.*, a.name as category, b.name as customer from products, categories as a, customers as b where a.id = products.category_id and b.id = products.customer_id ");
      $delURL = url('/') . '/admin/receipt/detail/destroy/';
      $ediURL = url('/') . '/admin/receipt/detail/edit/';
      // if( receipt_headers.finalized = 1, concat($delURL,receipt_headers.id) ,"")
      $receiptdetails =   DB::table('receipt_details' )
          ->select('receipt_details.*','receipt_headers.finalized','payment_types.name as paytype',
                DB::raw('concat("row_",receipt_details.id) as DT_RowId'),
                DB::raw('(CASE WHEN receipt_headers.finalized = 0 THEN concat("'.$delURL.'",receipt_details.id)
                        ELSE "" END) AS delete_url'),
                DB::raw('(CASE WHEN receipt_headers.finalized = 0 THEN concat("'.$ediURL.'",receipt_details.id,"")
                        ELSE "" END) AS edit_url'))
          ->join('receipt_headers', 'receipt_headers.id', '=', 'receipt_details.receipt_id')
          ->join('payment_types', 'payment_types.id', '=', 'receipt_details.paytype_id')
          ->where('receipt_details.receipt_id', '=', $id)
          ->get();


        return Datatables::of($receiptdetails)
         ->addColumn('actions', function($record){
           return view('includes._datatable_actions', [
               // 'showUrl'    => route('admin.receipt.show', [ $record->id] ),
               'deleteUrl'  => $record->delete_url,
               // 'editUrl'    => $record->edit_url,
               'editPurchaseItem' => $record->id,
               // 'deleteUrl' => route('admin.receipt.destroy', [ $record->id]),
               // 'editUrl' => route('admin.receipt.edit', [ $record->id])
           ]);
         })->make(true);





    }
    public function getInvoiceDatatable($id)
    {

      // $products = DB::select("select products.*, a.name as category, b.name as customer from products, categories as a, customers as b where a.id = products.category_id and b.id = products.customer_id ");
      $delURL = url('/') . '/admin/receipt/invoice/destroy/';
      $ediURL = url('/') . '/admin/receipt/invoice/';
      // if( receipt_headers.finalized = 1, concat($delURL,receipt_headers.id) ,"")
      $receiptdetails =   DB::table('receipt_invoices' )
          ->select('receipt_invoices.*','receipt_headers.finalized',
                DB::raw('concat("row_inv_",receipt_invoices.id) as DT_RowId'),
                DB::raw('concat("IMS",date_format(orders.order_date,"%Y%m%d"), orders.id) as invoiceno'),
                DB::raw('(CASE WHEN receipt_headers.finalized = 0 THEN concat("'.$delURL.'",receipt_invoices.id)
                        ELSE "" END) AS delete_url'),
                DB::raw('(CASE WHEN receipt_headers.finalized = 0 THEN concat("'.$ediURL.'",receipt_invoices.id,"/edit")
                        ELSE "" END) AS edit_url'))
          ->join('receipt_headers', 'receipt_headers.id', '=', 'receipt_invoices.receipt_id')
          ->join('orders', 'orders.id', '=', 'receipt_invoices.order_id')
          ->where('receipt_invoices.receipt_id', '=', $id)
          ->get();


        return Datatables::of($receiptdetails)
         ->addColumn('actions', function($record){
           return view('includes._datatable_actions', [
               // 'showUrl'    => route('admin.receipt.show', [ $record->id] ),
               'deleteUrl'  => $record->delete_url,
               // 'editUrl'    => $record->edit_url,
               'editTable2' => $record->id,

               // 'deleteUrl' => route('admin.receipt.destroy', [ $record->id]),
               // 'editUrl' => route('admin.receipt.edit', [ $record->id])
           ]);
         })->make(true);





    }

    public function show($id)
    {

        $receiptheader = ReceiptHeader::find($id);
        // $orders = DB::table("orders")
        //   ->select('*')
        //   ->where('customer_id','=',$receiptheader->customer_id)
        //   ->where('balance','>',0)
        //   ->get();
        $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
        $merchants = Merchant::orderBy('id', 'asc') ->get();
        return view('admin.receipt.show', compact('receiptheader','paymenttypes','merchants'));
    }
    public function print($id)
    {

        $receiptheader = ReceiptHeader::find($id);
        $receiptdetails = DB::table("receipt_details")
          ->select("receipt_details.*", "payment_types.name")
          ->join("payment_types","payment_types.id","=","receipt_details.paytype_id")
          ->where("receipt_details.receipt_id","=",$id)->get();
          
        $receiptinvoices =  DB::table("receipt_invoices")
          ->select("receipt_invoices.*", "orders.order_date",
            DB::raw('concat("IMS",date_format(orders.order_date,"%Y%m%d"), orders.id) as invoiceno'))
          ->join("orders","orders.id","=","receipt_invoices.order_id")
          ->where("receipt_invoices.receipt_id","=",$id)->get();

        $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
        $merchants = Merchant::orderBy('id', 'asc') ->get();
        return view('admin.receipt.print', compact('receiptheader','paymenttypes','merchants','receiptinvoices','receiptdetails'));
    }
    public function create()
    {
        // $products = Product::all();
        $customers = Customer::all();
        return view('admin.receipt.create', compact( 'customers'));
    }

    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
            'customer_id' => 'required',
            'receipt_date' => 'required',

        ];
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Header : Store data in your database table
          $receiptheader = new ReceiptHeader();
          $receiptheader->customer_id = $request->input('customer_id');
          $receiptheader->orno = $request->input('orno');
          $receiptheader->receipt_date = $request->input('receipt_date');
          $receiptheader->notes = $request->input('notes');
          $receiptheader->save();

        // update customer balance
        $customer = new Customer; //::find($request->input('variant_id'));
        $customer->updateLatestBalance($request->input('customer_id'));


        Toastr::success('Receipt Header successfully created', 'Success');
         return redirect()->route('admin.receipt.show',$receiptheader);

    }
    public function storeDetail  (Request $request, $id)
    {

        $inputs = $request->except('_token');
        $rules = [
            'paytype_id' => 'required | integer',
            'payment_status' => 'required',
            'payment' => 'required',
        ];
        $customMessages = [

            'payment.required' => 'Enter Payment amount first!.',
        ];
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $payment = $request->input('payment');

        $receiptdetails = new ReceiptDetail();
        $receiptdetails->receipt_id = $id;
        $receiptdetails->paytype_id = $request->input('paytype_id');
        $receiptdetails->merchant_id = $request->input('merchant_id');
        $receiptdetails->amount = $payment;
        $receiptdetails->refno = $request->input('refno');
        $receiptdetails->refname = $request->input('refname');
        $receiptdetails->refdate = $request->input('refdate');
        $receiptdetails->approval_id = $request->input('approval_id');
        $receiptdetails->approval_date = $request->input('approval_date');
        $receiptdetails->save();

        ReceiptController::updatePaidDetail($id);

        Toastr::success('Receipt Detail successfully added', 'Success');
        $receiptheader = ReceiptHeader::find($id);
        // $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
        // $merchants = Merchant::orderBy('id', 'asc') ->get();
        return redirect()->route('admin.receipt.show', $receiptheader);
    }
    public function storeInvoice  (Request $request, $id)
    {

        $inputs = $request->except('_token');
        $rules = [
            'order_id' => 'required | integer',
            'paid_invoice' => 'required',

        ];
        $customMessages = [

            'paid_invoice.required' => 'Enter Invoice Payment first!.',
        ];
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $payment = $request->input('paid_invoice');

        $receiptinvoice = new ReceiptInvoice();
        $receiptinvoice->receipt_id = $id;
        $receiptinvoice->order_id = $request->input('order_id');
        $receiptinvoice->discount = $request->input('discount');
        $receiptinvoice->amount = $payment;
        $receiptinvoice->save();

        ReceiptController::updatePaidInvoice($id);


        $order = new Order;
        $order->updateOrderPay($request->input('order_id'));
        // $order->save();



        Toastr::success('Receipt Invoice successfully added', 'Success');
        $receiptheader = ReceiptHeader::find($id);
        // update customer balance
        $customer = new Customer;
        $customer->updateLatestBalance($receiptheader->customer_id);

        // $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
        // $merchants = Merchant::orderBy('id', 'asc') ->get();
        return redirect()->route('admin.receipt.show', $receiptheader);
    }
    public function updatePaidDetail($id)
    {
          $receiptheader = ReceiptHeader::find($id);
          $receiptdetails =   DB::table('receipt_details' )
          ->select("receipt_details.*", DB::raw('SUM(receipt_details.amount) as sum_amount'))
          ->where('receipt_details.receipt_id','=',$id)
          ->groupBy('receipt_details.receipt_id')
          ->get();
          $totalsum = 0;
          foreach ( $receiptdetails  as $receiptdetail ){
              $totalsum = $receiptdetail->sum_amount;
          }
          $receiptheader->paid_detail = $totalsum;
          $receiptheader->save();
          return;
    }
    public function updatePaidInvoice($id)
    {
          $receiptheader = ReceiptHeader::find($id);
          $receiptinvoices =   DB::table('receipt_invoices' )
          ->select("*", DB::raw('SUM(amount) as sum_amount'),
                DB::raw('SUM(discount) as sum_discount'))
          ->where('receipt_id','=',$id)
          ->groupBy('receipt_id')
          ->get();
          $totalsum = 0;
          $totaldiscount = 0;
          foreach ( $receiptinvoices  as $receiptinvoice ){
              $totalsum = $receiptinvoice->sum_amount;
              $totaldiscount = $receiptinvoice->sum_discount;
          }
          $receiptheader->paid_invoice = $totalsum;
          $receiptheader->discount = $totaldiscount;
          $receiptheader->total = $totalsum + $totaldiscount;
          $receiptheader->save();
          return;
    }
    public function edit($id)
    {
        //
        // $receiptheader = ReceiptDetail::find($id);
        // return view('admin.purchase.edit', compact('receiptheader'));
    }

    public function update(Request $request)
    {
      $inputs = $request->except('_token');
      $rules = [
          'customer_id' => 'required',
          'receipt_id' => 'required',
          'receipt_date' => 'required',

      ];
      $validator = Validator::make($inputs, $rules);
      if ($validator->fails())
      {
          return redirect()->back()->withErrors($validator)->withInput();
      }
      // Header : Update data in your database table
      $receiptheader = ReceiptHeader::find($request->input('receipt_id'));

      $receiptheader->orno = $request->input('orno');
      $receiptheader->receipt_date = $request->input('receipt_date');
      $receiptheader->notes = $request->input('notes');
      $receiptheader->save();

      Toastr::success('Receipt Header successfully Updated!!!', 'Updated');
       return redirect()->route('admin.receipt.index');

    }

    public function updateFinalized( $id)
    {
        $receiptheader = ReceiptHeader::find($id);
        $receiptheader->finalized = 1;
        $receiptheader->finalized_date = date("Y-m-d");
        $receiptheader->save();
        Toastr::success('Receipt Status successfully Finalized!!!', 'Success');

        return redirect()->route('admin.receipt.show', $receiptheader);
    }

    public function updateDetail(Request $request)
    {
          $inputs = $request->except('_token');
          $rules = [
              'paytype_id' => 'required | integer',
              'payment_status' => 'required',
              'payment' => 'required',
          ];
          $customMessages = [
              'payment.required' => 'Enter Payment amount first!.',
          ];
          $validator = Validator::make($inputs, $rules);
          if ($validator->fails())
          {
              return redirect()->back()->withErrors($validator)->withInput();
          }
          $id = $request->input('paydetail_id');
          $payment = $request->input('payment');

          $receiptdetail = ReceiptDetail::find($id);
          $receipt_id = $receiptdetail->receipt_id;
          $receiptdetail->paytype_id = $request->input('paytype_id');
          $receiptdetail->merchant_id = $request->input('merchant_id');
          $receiptdetail->amount = $payment;
          $receiptdetail->refno = $request->input('refno');
          $receiptdetail->refname = $request->input('refname');
          $receiptdetail->refdate = $request->input('refdate');
          $receiptdetail->approval_id = $request->input('approval_id');
          $receiptdetail->approval_date = $request->input('approval_date');
          $receiptdetail->save();

          ReceiptController::updatePaidDetail($receipt_id);

          Toastr::success('Receipt Detail successfully Updated', 'Success');
          $receiptheader = ReceiptHeader::find($receipt_id);
          // $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
          // $merchants = Merchant::orderBy('id', 'asc') ->get();
          return redirect()->route('admin.receipt.show', $receiptheader);
    }
    public function updateInvoice(Request $request, $id)
    {
          $inputs = $request->except('_token');
          $rules = [
            'order_id2' => 'required | integer',
            'paid_invoice' => 'required',
            'payinvoice_id' => 'required',
          ];
          $customMessages = [
              'paid_invoice.required' => 'Enter Payment amount first!.',
          ];
          $validator = Validator::make($inputs, $rules);
          if ($validator->fails())
          {
              return redirect()->back()->withErrors($validator)->withInput();
          }
          $payinvoice_id = $request->input('payinvoice_id');
          $payment = $request->input('paid_invoice');

          $receiptinvoice = ReceiptInvoice::find($payinvoice_id);;
          $receiptinvoice->discount = $request->input('discount');
          $receiptinvoice->amount = $payment;
          $receiptinvoice->save();

          ReceiptController::updatePaidInvoice($receiptinvoice->receipt_id);


          $order = new Order;
          $order->updateOrderPay($receiptinvoice->order_id);
          // $order->save();




          $receiptheader = ReceiptHeader::find($receiptinvoice->receipt_id);
          // update customer balance
          $customer = new Customer;
          $customer->updateLatestBalance($receiptheader->customer_id);

          // $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
          // $merchants = Merchant::orderBy('id', 'asc') ->get();
          Toastr::success('Receipt Invoice successfully Udated', 'Success');
          return redirect()->route('admin.receipt.show', $receiptheader);
    }

    public function destroyDetail($id)
    {

      $receiptdetail = ReceiptDetail::find($id);
      $receipt_id = $receiptdetail->receipt_id;
      $receiptdetail->delete();

      // Update Header Paid Detail
      ReceiptController::updatePaidDetail($receipt_id);
      $receiptheader = ReceiptHeader::find($receipt_id);
      Toastr::success('Receipt Detail ID: '.$id.' successfully deleted', 'Deleted');
      return redirect()->route('admin.receipt.show', $receiptheader);

    }
    public function destroyInvoice($id)
    {

      $receiptinvoice = ReceiptInvoice::find($id);
      $receipt_id = $receiptinvoice->receipt_id;
      $order_id = $receiptinvoice->order_id;
      $receiptinvoice->delete();

      // Update Header Paid Detail
      ReceiptController::updatePaidInvoice($receipt_id);


      $order = new Order;
      $order->updateOrderPay($order_id);
      // $order->save();




      $receiptheader = ReceiptHeader::find($receipt_id);
      // update customer balance
      $customer = new Customer;
      $customer->updateLatestBalance($receiptheader->customer_id);

      Toastr::success('Receipt Invoice ID: '.$id.' successfully deleted', 'Deleted');
      return redirect()->route('admin.receipt.show', $receiptheader);

    }
    public function destroy($id)
    {
      $receiptheader = ReceiptHeader::find($id);
      $customer_id = $receiptheader->customer_id;
      $receiptdetails = ReceiptDetail::where('receipt_id','=',$id)->get();
      foreach($receiptdetails as $receiptdetail){

        $receiptdetail->delete();

      }
      $receiptinvoices = ReceiptInvoice::where('receipt_id','=',$id)->get();
      foreach($receiptinvoices as $receiptinvoice){
        $order_id = $receiptinvoice->order_id;
        $receiptinvoice->delete();

        $order = new Order;
        $order->updateOrderPay($order_id);
      }
      // update customer balance
      $receiptheader->delete();

      $customer = new Customer;
      $customer->updateLatestBalance($customer_id);

      Toastr::success('Receipt ID: '.$id.' successfully deleted', 'Deleted');
      return redirect()->route('admin.receipt.index');
    }


}
