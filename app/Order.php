<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function updateOrderPay($id)
    {
      $lesstotal =0;
      $addtotal =0;
      $discount =0;
      $receiptinvoices = ReceiptInvoice::select("receipt_invoices.*", DB::raw('SUM(amount) as sumtotal'), DB::raw('SUM(discount) as sumdiscount'))
        ->where('order_id','=',$id)
        ->groupBy('order_id')
        ->get();

        foreach($receiptinvoices as $receiptinvoice){
           $lesstotal = $receiptinvoice->sumtotal;
               $discount =$receiptinvoice->sumdiscount;
        }


      $order = Order::find($id);
      $order->pay = $lesstotal+$discount;
      $order->balance = $order->total - $lesstotal - $discount;
      $order->save();

    }
}
