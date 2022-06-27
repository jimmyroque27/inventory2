<?php

namespace App\Http\Controllers;
use App\Supplier;
use App\PaymentHeader;
use App\PaymentDetail;
use App\PaymentPurchase;

use App\PurchaseHeader;
use App\PaymentType;
use App\Merchant;

use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables ;

class PaymentController extends Controller
{
    //
    public function index()
    {
        // $paymentheaders = PaymentHeader::latest()->with('supplier')->get();
        return view('admin.payment.index' );
    }

    public function getDatatable()
    {
      $delURL = url('/') . '/admin/payment/destroy/';
      $ediURL = url('/') . '/admin/payment/';
      // if( payment_headers.finalized = 1, concat($delURL,payment_headers.id) ,"")
      $paymentheaders =   DB::table('payment_headers' )
          ->select('payment_headers.*','suppliers.name as supplier',
                DB::raw('concat("row_",payment_headers.id) as DT_RowId'),
                DB::raw('(CASE WHEN payment_headers.finalized = 0 THEN concat("'.$delURL.'",payment_headers.id)
                        ELSE ""
                        END) AS delete_url'),
                DB::raw('(CASE WHEN payment_headers.finalized = 0 THEN concat("'.$ediURL.'",payment_headers.id,"/edit")
                        ELSE ""
                        END) AS edit_url'))
          ->join('suppliers', 'suppliers.id', '=', 'payment_headers.supplier_id')
          ->get();


        return Datatables::of($paymentheaders)
         ->addColumn('actions', function($record){
           return view('includes._datatable_actions', [
               'showUrl'    => route('admin.payment.show', [ $record->id] ),
               'deleteUrl'  => $record->delete_url,
               // 'editUrl'    => $record->edit_url,
                'editPurchaseItem' => $record->id,
               // 'deleteUrl' => route('admin.payment.destroy', [ $record->id]),
               // 'editUrl' => route('admin.payment.edit', [ $record->id])
           ]);
         })->make(true);





    }
    public function getDetailsDatatable($id)
    {

      $delURL = url('/') . '/admin/payment/detail/destroy/';
      $ediURL = url('/') . '/admin/payment/detail/edit/';
      // if( _headers.finalized = 1, concat($delURL,_headers.id) ,"")
      $paymentdetails =   DB::table('payment_details' )
          ->select('payment_details.*','payment_headers.finalized','payment_types.name as paytype',
                DB::raw('concat("row_",payment_details.id) as DT_RowId'),
                DB::raw('(CASE WHEN payment_headers.finalized = 0 THEN concat("'.$delURL.'",payment_details.id)
                        ELSE "" END) AS delete_url'),
                DB::raw('(CASE WHEN payment_headers.finalized = 0 THEN concat("'.$ediURL.'",payment_details.id,"")
                        ELSE "" END) AS edit_url'))
          ->join('payment_headers', 'payment_headers.id', '=', 'payment_details.payment_id')
          ->join('payment_types', 'payment_types.id', '=', 'payment_details.paytype_id')
          ->where('payment_details.payment_id', '=', $id)
          ->get();


        return Datatables::of($paymentdetails)
         ->addColumn('actions', function($record){
           return view('includes._datatable_actions', [
               // 'showUrl'    => route('admin.payment.show', [ $record->id] ),
               'deleteUrl'  => $record->delete_url,
               // 'editUrl'    => $record->edit_url,
               'editPurchaseItem' => $record->id,
               // 'deleteUrl' => route('admin.payment.destroy', [ $record->id]),
               // 'editUrl' => route('admin.payment.edit', [ $record->id])
           ]);
         })->make(true);





    }
    public function getPurchaseDatatable($id)
    {
      $delURL = url('/') . '/admin/payment/purchase/destroy/';
      $ediURL = url('/') . '/admin/payment/purchase/';
      // if( payment_headers.finalized = 1, concat($delURL,payment_headers.id) ,"")
      $paymentdetails =   DB::table('payment_purchases' )
          ->select('payment_purchases.*','payment_headers.finalized',
                DB::raw('concat("row_inv_",payment_purchases.id) as DT_RowId'),
                DB::raw('concat("IMS",date_format(purchase_headers.purchase_date,"%Y%m%d"), purchase_headers.id) as purchaseno'),
                DB::raw('(CASE WHEN payment_headers.finalized = 0 THEN concat("'.$delURL.'",payment_purchases.id)
                        ELSE "" END) AS delete_url'),
                DB::raw('(CASE WHEN payment_headers.finalized = 0 THEN concat("'.$ediURL.'",payment_purchases.id,"/edit")
                        ELSE "" END) AS edit_url'))
          ->join('payment_headers', 'payment_headers.id', '=', 'payment_purchases.payment_id')
          ->join('purchase_headers', 'purchase_headers.id', '=', 'payment_purchases.purchase_id')
          ->where('payment_purchases.payment_id', '=', $id)
          ->get();


        return Datatables::of($paymentdetails)
         ->addColumn('actions', function($record){
           return view('includes._datatable_actions', [
               // 'showUrl'    => route('admin.payment.show', [ $record->id] ),
               'deleteUrl'  => $record->delete_url,
               // 'editUrl'    => $record->edit_url,
               'editTable2' => $record->id,

               // 'deleteUrl' => route('admin.payment.destroy', [ $record->id]),
               // 'editUrl' => route('admin.payment.edit', [ $record->id])
           ]);
         })->make(true);





    }

    public function show($id)
    {

        $paymentheader = PaymentHeader::find($id);
        // $purchaseheaders = DB::table("purchase_headers")
        //   ->select('*')
        //   ->where('supplier_id','=',$paymentheader->supplier_id)
        //   ->where('balance','>',0)
        //   ->get();
        $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
        $merchants = Merchant::orderBy('id', 'asc') ->get();
        return view('admin.payment.show', compact('paymentheader','paymenttypes','merchants'));
    }

    public function create()
    {

        $suppliers = Supplier::all();
        return view('admin.payment.create', compact( 'suppliers'));
    }

    public function store(Request $request)
    {
        $inputs = $request->except('_token');
        $rules = [
            'supplier_id' => 'required',
            'payment_date' => 'required',

        ];
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Header : Store data in your database table
        $paymentheader = new PaymentHeader();
        $paymentheader->supplier_id = $request->input('supplier_id');
        $paymentheader->orno = $request->input('orno');
        $paymentheader->payment_date = $request->input('payment_date');
        $paymentheader->notes = $request->input('notes');
        $paymentheader->save();


        Toastr::success('Payment Purchase Header successfully created', 'Success');
         return redirect()->route('admin.payment.show',$paymentheader);

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

        $paymentdetail = new PaymentDetail();
        $paymentdetail->payment_id = $id;
        $paymentdetail->paytype_id = $request->input('paytype_id');
        $paymentdetail->merchant_id = $request->input('merchant_id');
        $paymentdetail->amount = $payment;
        $paymentdetail->refno = $request->input('refno');
        $paymentdetail->refname = $request->input('refname');
        $paymentdetail->refdate = $request->input('refdate');
        $paymentdetail->approval_id = $request->input('approval_id');
        $paymentdetail->approval_date = $request->input('approval_date');
        $paymentdetail->save();

        PaymentController::updatePaidDetail($id);

        Toastr::success('Payment Purchase Detail successfully added', 'Success');
        $paymentheader = PaymentHeader::find($id);
        // $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
        // $merchants = Merchant::orderBy('id', 'asc') ->get();
        return redirect()->route('admin.payment.show', $paymentheader);
    }
    public function storePurchase  (Request $request, $id)
    {

        $inputs = $request->except('_token');
        $rules = [
            'purchase_id' => 'required | integer',
            'paid_purchase' => 'required',

        ];
        $customMessages = [

            'paid_purchase.required' => 'Enter Purchase Payment first!.',
        ];
        $validator = Validator::make($inputs, $rules);
        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $payment = $request->input('paid_purchase');

        $paymentpurchase = new PaymentPurchase();
        $paymentpurchase->payment_id = $id;
        $paymentpurchase->purchase_id = $request->input('purchase_id');
        $paymentpurchase->discount = $request->input('discount');
        $paymentpurchase->amount = $payment;
        $paymentpurchase->save();

        PaymentController::updatePaidPurchase($id);


        $purchaseheader = new PurchaseHeader;
        $purchaseheader->updatePurchaseHeaderPay($request->input('purchase_id'));
        // $purchaseheader->save();



        Toastr::success('Payment Purchase successfully added', 'Success');
        $paymentheader = PaymentHeader::find($id);
        // update supplier balance
        $supplier = new Supplier;
        $supplier->updateLatestBalance($paymentheader->supplier_id);

        // $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
        // $merchants = Merchant::orderBy('id', 'asc') ->get();
        return redirect()->route('admin.payment.show', $paymentheader);
    }
    public function updatePaidDetail($id)
    {
          $paymentheader = PaymentHeader::find($id);
          $paymentdetails =   DB::table('payment_details' )
          ->select("payment_details.*", DB::raw('SUM(payment_details.amount) as sum_amount'))
          ->where('payment_details.payment_id','=',$id)
          ->groupBy('payment_details.payment_id')
          ->get();
          $totalsum = 0;
          foreach ( $paymentdetails  as $paymentdetail ){
              $totalsum = $paymentdetail->sum_amount;
          }
          $paymentheader->paid_detail = $totalsum;
          $paymentheader->save();
          return;
    }
    public function updatePaidPurchase($id)
    {
          $paymentheader = PaymentHeader::find($id);
          $paymentpurchases =   DB::table('payment_purchases' )
          ->select("*", DB::raw('SUM(amount) as sum_amount'),
                DB::raw('SUM(discount) as sum_discount'))
          ->where('payment_id','=',$id)
          ->groupBy('payment_id')
          ->get();
          $totalsum = 0;
          $totaldiscount = 0;
          foreach ( $paymentpurchases  as $paymentpurchase ){
              $totalsum = $paymentpurchase->sum_amount;
              $totaldiscount = $paymentpurchase->sum_discount;
          }
          $paymentheader->paid_purchase = $totalsum;
          $paymentheader->discount = $totaldiscount;
          $paymentheader->total = $totalsum + $totaldiscount;
          $paymentheader->save();
          return;
    }
    public function edit($id)
    {
        //
        // $paymentheader = PaymentDetail::find($id);
        // return view('admin.purchase.edit', compact('paymentheader'));
    }

    public function update(Request $request)
    {
      $inputs = $request->except('_token');
      $rules = [
          'supplier_id' => 'required',
          'payment_id' => 'required',
          'payment_date' => 'required',

      ];
      $validator = Validator::make($inputs, $rules);
      if ($validator->fails())
      {
          return redirect()->back()->withErrors($validator)->withInput();
      }
      // Header : Update data in your database table
      $paymentheader = PaymentHeader::find($request->input('payment_id'));

      $paymentheader->orno = $request->input('orno');
      $paymentheader->payment_date = $request->input('payment_date');
      $paymentheader->notes = $request->input('notes');
      $paymentheader->save();

      Toastr::success('Payment Header successfully Updated!!!', 'Updated');
       return redirect()->route('admin.payment.index');

    }

    public function updateFinalized( $id)
    {
        $paymentheader = PaymentHeader::find($id);
        $paymentheader->finalized = 1;
        $paymentheader->finalized_date = date("Y-m-d");
        $paymentheader->save();
        Toastr::success('Payment Purchae Status successfully Finalized!!!', 'Success');

        return redirect()->route('admin.payment.show', $paymentheader);
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

          $paymentdetail = PaymentDetail::find($id);
          $payment_id = $paymentdetail->payment_id;
          $paymentdetail->paytype_id = $request->input('paytype_id');
          $paymentdetail->merchant_id = $request->input('merchant_id');
          $paymentdetail->amount = $payment;
          $paymentdetail->refno = $request->input('refno');
          $paymentdetail->refname = $request->input('refname');
          $paymentdetail->refdate = $request->input('refdate');
          $paymentdetail->approval_id = $request->input('approval_id');
          $paymentdetail->approval_date = $request->input('approval_date');
          $paymentdetail->save();

          PaymentController::updatePaidDetail($payment_id);

          Toastr::success('Payment Purchase Detail successfully Updated', 'Success');
          $paymentheader = PaymentHeader::find($payment_id);
          // $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
          // $merchants = Merchant::orderBy('id', 'asc') ->get();
          return redirect()->route('admin.payment.show', $paymentheader);
    }
    public function updatePurchase(Request $request, $id)
    {
          $inputs = $request->except('_token');
          $rules = [
            'purchase_id2' => 'required | integer',
            'paid_purchase' => 'required',
            'paypurchase_id' => 'required',
          ];
          $customMessages = [
              'paid_purchase.required' => 'Enter Payment amount first!.',
          ];
          $validator = Validator::make($inputs, $rules);
          if ($validator->fails())
          {
              return redirect()->back()->withErrors($validator)->withInput();
          }
          $paypurchase_id = $request->input('paypurchase_id');
          $payment = $request->input('paid_purchase');

          $paymentpurchase = PaymentPurchase::find($paypurchase_id);;
          $paymentpurchase->discount = $request->input('discount');
          $paymentpurchase->amount = $payment;
          $paymentpurchase->save();

          PaymentController::updatePaidPurchase($paymentpurchase->payment_id);


          $purchaseheader = new PurchaseHeader;
          $purchaseheader->updatePurchaseHeaderPay($paymentpurchase->purchase_id);
          // $purchaseheader->save();




          $paymentheader = PaymentHeader::find($paymentpurchase->payment_id);
          // update supplier balance
          $supplier = new Supplier;
          $supplier->updateLatestBalance($paymentheader->supplier_id);

          // $paymenttypes = PaymentType::orderBy('id', 'asc') ->get();
          // $merchants = Merchant::orderBy('id', 'asc') ->get();
          Toastr::success('Payment Purchase successfully Udated', 'Success');
          return redirect()->route('admin.payment.show', $paymentheader);
    }

    public function destroyDetail($id)
    {

      $paymentdetail = PaymentDetail::find($id);
      $payment_id = $paymentdetail->payment_id;
      $paymentdetail->delete();

      // Update Header Paid Detail
      PaymentController::updatePaidDetail($payment_id);
      $paymentheader = PaymentHeader::find($payment_id);
      Toastr::success('Payment Purchase Detail ID: '.$id.' successfully deleted', 'Deleted');
      return redirect()->route('admin.payment.show', $paymentheader);

    }
    public function destroyPurchase($id)
    {

      $paymentpurchase = PaymentPurchase::find($id);
      $payment_id = $paymentpurchase->payment_id;
      $purchase_id = $paymentpurchase->purchase_id;
      $paymentpurchase->delete();

      // Update Header Paid Detail
      PaymentController::updatePaidPurchase($payment_id);


      $purchaseheader = new PurchaseHeader;
      $purchaseheader->updatePurchaseHeaderPay($purchase_id);
      // $purchaseheader->save();




      $paymentheader = PaymentHeader::find($payment_id);
      // update supplier balance
      $supplier = new Supplier;
      $supplier->updateLatestBalance($paymentheader->supplier_id);

      Toastr::success('Payment Purchase ID: '.$id.' successfully deleted', 'Deleted');
      return redirect()->route('admin.payment.show', $paymentheader);

    }
    public function destroy($id)
    {
      $paymentheader = PaymentHeader::find($id);
      $supplier_id = $paymentheader->supplier_id;
      $paymentdetails = PaymentDetail::where('payment_id','=',$id)->get();
      foreach($paymentdetails as $paymentdetail){
        $paymentdetail->delete();
      }
      $paymentpurchases = PaymentPurchase::where('payment_id','=',$id)->get();
      foreach($paymentpurchases as $paymentpurchase){
        $purchase_id = $paymentpurchase->purchase_id;
        $paymentpurchase->delete();

        $purchaseheader = new PurchaseHeader;
        $purchaseheader->updatePurchaseHeaderPay($purchase_id);
      }
      // update supplier balance
      $paymentheader->delete();

      $supplier = new Supplier;
      $supplier->updateLatestBalance($supplier_id);

      Toastr::success('Payment Purchase ID: '.$id.' successfully deleted', 'Deleted');
      return redirect()->route('admin.payment.index');
    }


}
