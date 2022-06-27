<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Supplier extends Model
{
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function purchaseheaders()
    {
        return $this->hasMany(PurchaseHeader::class);
    }
    public function paymentpurchases()
    {
        return $this->hasMany(PaymentPurchase::class);
    }
    public function updateLatestBalance($id)
    {
      $lesstotal =0;
      $addtotal =0;
      $purchasesheaders = PurchaseHeader::select("purchase_headers.*", DB::raw('SUM(total) as sumtotal'))
        ->where('supplier_id','=',$id)
        ->groupBy('supplier_id')
        ->get();

        foreach($purchasesheaders as $purchasesheader){
           $addtotal = $purchasesheader->sumtotal;
        }
      $paymentheaders = DB::table('payment_headers' )
      ->select("supplier_id",
        DB::raw('SUM(total) as sumtotal'))
      ->where('supplier_id','=',$id)
      ->groupBy('supplier_id')
        ->get();

        foreach($paymentheaders as $paymentheader){
           $lesstotal = $paymentheader->sumtotal;
        }
      $supplier = Supplier::find($id);

      $supplier->balance = $addtotal - $lesstotal;
      $supplier->save();

    }
}
