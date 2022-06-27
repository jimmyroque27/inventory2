<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function receiptheaders()
    {
        return $this->hasMany(ReceiptHeader::class);
    }
    public function updateLatestBalance($id)
    {
      $lesstotal =0;
      $addtotal =0;
      $orders = Order::select("orders.*", DB::raw('SUM(total) as sumtotal'))
        ->where('customer_id','=',$id)
        ->groupBy('customer_id')
        ->get();

        foreach($orders as $order){
           $addtotal = $order->sumtotal;
        }
      $receiptheaders = DB::table('receipt_headers' )
      ->select("customer_id",
        DB::raw('SUM(total) as sumtotal'))
      ->where('customer_id','=',$id)
      ->groupBy('customer_id')
        ->get();

        foreach($receiptheaders as $receiptheader){
           $lesstotal = $receiptheader->sumtotal;
        }
      $customer = Customer::find($id);

      $customer->balance = $addtotal - $lesstotal;
      $customer->save();

    }
}
