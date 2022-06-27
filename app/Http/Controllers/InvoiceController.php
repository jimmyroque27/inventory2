<?php

namespace App\Http\Controllers;

use App\Customer;
use App\PaymentType;
use App\Merchant;
use App\ReceiptHeader;
use App\ReceiptDetail;
use App\ReceiptInvoice;
use App\ProductVariant;
use App\Order;
use Illuminate\Support\Facades\DB;
use App\OrderDetail;
use App\Setting;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function create(Request $request)
    {

        $inputs = $request->except('_token');
        $rules = [
          'customer_id' => 'required | integer',
        ];
        $customMessages = [
            'customer_id.required' => 'Select a Customer first!.',
            'customer_id.integer' => 'Invalid Customer!.'
        ];
        $validator = Validator::make($inputs, $rules, $customMessages);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $errormsg = "";
        $contents = Cart::content();
        foreach ($contents as $content)
        {
            $productvariant = ProductVariant::find($content->id);
            if ($productvariant->onhand < $content->qty){
              $errormsg = $errormsg . 'Insufficient Qty (On-hand: '.$productvariant->onhand.') for Item: '.$content->name ."<br>" ;

            }

        }
        if ($errormsg != ""){
          Toastr::error($errormsg , 'Warning!!!');
          return redirect()->back()->withErrors($validator)->withInput();
        }


        $customer_id = $request->input('customer_id');
        $customer = Customer::findOrFail($customer_id);
        $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
        $merchants = Merchant::orderBy('id', 'asc') ->get();
        $contents = Cart::content();
        $company  = Setting::latest()->first();
        return view('admin.invoice', compact('customer', 'contents', 'company','paymenttypes','merchants'));
    }

    public function print($customer_id)
    {
        $customer = Customer::findOrFail($customer_id);
        $contents = Cart::content();
        $company = Setting::latest()->first();
        return view('admin.print', compact('customer', 'contents', 'company'));
    }

    public function order_print($order_id)
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
        return view('admin.order.print', compact('order_details', 'order', 'company'));
    }


    public function final_invoice(Request $request)
    {
        $inputs = $request->except('_token');

        $rules = [
          'paytype_id' => 'required',
          'payment_status' => 'required',
          'pay' => 'required',
          'customer_id' => 'required | integer',
        ];
        $customMessages = [
            'payment_status.required' => 'Select a Payment method first!.',
            'paytype_id.required' => 'Select a Payment method first!.',
            'pay.required' => 'Enter Payment amount first!.',
        ];

        $validator = Validator::make($inputs, $rules, $customMessages);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $errormsg = "";
        $contents = Cart::content();
        foreach ($contents as $content)
        {
            $productvariant = ProductVariant::find($content->id);
            if ($productvariant->onhand < $content->qty){
              $errormsg = $errormsg . 'Some Items are taken-out!!! <br> Insufficient Qty (On-hand: '.$productvariant->onhand.') for Item: '.$content->name ."<br>" ;

            }

        }
        if ($errormsg != ""){
          Toastr::error($errormsg , 'Warning!!!');
          return redirect()->back()->withErrors($validator)->withInput();
        }

        $sub_total = str_replace(',', '', Cart::subtotal());
        $tax = str_replace(',', '', Cart::tax());
        $total = str_replace(',', '', Cart::total());

        $pay = $request->input('pay');
        $balance = $total - $pay;

        $order = new Order();
        $order->customer_id = $request->input('customer_id');
        $order->payment_status = $request->input('payment_status');

        if ($request->input('paytype_id') != "7"){ // None Receivable
          $order->pay = $pay;
          $order->balance = $balance;
        }else {
          $order->pay = 0;
          $order->balance = $total;
        }
        $order->order_date = date('Y-m-d');
        $order->order_status = 'pending';
        $order->total_products = Cart::count();
        $order->sub_total = $sub_total;
        $order->vat = $tax;
        $order->total = $total;
        $order->save();

        $order_id = $order->id;


        $contents = Cart::content();

        foreach ($contents as $content)
        {
            $productvariant = ProductVariant::find($content->id);
            $order_detail = new OrderDetail();
            $order_detail->order_id = $order_id;
            $order_detail->variant_id = $content->id;
            $order_detail->product_id = $productvariant->product_id;
            $order_detail->qty = $content->qty;
            $order_detail->unit_cost = $content->price;
            $order_detail->discount = $content->discount;
            $order_detail->total = $content->total;
            $order_detail->save();
            // Update Product Onhand

            $productvariant = new ProductVariant; //::find($request->input('variant_id'));
            $productvariant->updateLatestQty($content->id);

            // $order_detail->close();
        }

        Cart::destroy();
        if ($request->input('paytype_id') != "7"){ // None Receivable
          $receiptheader = new ReceiptHeader();
          $receiptheader->customer_id = $request->input('customer_id');

          $receiptheader->total = $pay;

          $receiptheader->receipt_date = date('Y-m-d');

          $receiptheader->save();


          $receiptinvoice = new ReceiptInvoice();
          $receiptinvoice->receipt_id = $receiptheader->id;
          $receiptinvoice->order_id = $order_id;
          $receiptinvoice->amount = $pay;
          $receiptinvoice->save();


          $receiptdetails = new ReceiptDetail();
          $receiptdetails->receipt_id = $receiptheader->id;

          $receiptdetails->paytype_id = $request->input('paytype_id');
          $receiptdetails->merchant_id = $request->input('merchant_id');
          $receiptdetails->amount = $pay;
          $receiptdetails->refno = $request->input('refno');
          $receiptdetails->refname = $request->input('refname');
          $receiptdetails->refdate = $request->input('refdate');
          $receiptdetails->approval_id = $request->input('approval_id');
          $receiptdetails->approval_date = $request->input('approval_date');

          $receiptdetails->save();

          $orno = date_create($receiptheader->receipt_date)->format('Ymd').$receiptheader->id;
          $receiptheader->orno =  $orno;
          $receiptheader->save();
        }
        // update supplier balance
        $customer = new Customer; //::find($request->input('variant_id'));
        $customer->updateLatestBalance($request->input('customer_id'));


        Toastr::success('Invoice created successfully', 'Success');
        return redirect()->route('admin.order.pending');


    }



}
