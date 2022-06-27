<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class PurchaseHeader extends Model
{
    //
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purchasedetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
    public function updatePurchaseHeaderPay($id)
    {
      $lesstotal =0;
      $addtotal =0;
      $discount =0;
      $paymentpurchases = PaymentPurchase::select("payment_purchases.*", DB::raw('SUM(amount) as sumtotal'), DB::raw('SUM(discount) as sumdiscount'))
        ->where('purchase_id','=',$id)
        ->groupBy('purchase_id')
        ->get();

        foreach($paymentpurchases as $paymentpurchase){
           $lesstotal = $paymentpurchase->sumtotal;
               $discount =$paymentpurchase->sumdiscount;
        }


      $purchaseheader = PurchaseHeader::find($id);
      $purchaseheader->pay = $lesstotal+$discount;
      $purchaseheader->balance = $purchaseheader->total - $lesstotal - $discount;
      $purchaseheader->save();

    }
}
