<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductVariant extends Model
{
    protected $dates = [
        'buying_date', 'expire_date',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function purchasedetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
    public function orderdetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function updateLatestQty($id)
    {
      $purchasedetails = PurchaseDetail::select("purchase_details.*", DB::raw('SUM(qty) as tqty'))
        ->where('variant_id','=',$id)
        ->groupBy('variant_id')
        ->get();
        $addqty =0;
        foreach($purchasedetails as $purchasedetail){
           $addqty = $purchasedetail->tqty;
        }
      $orderdetails = OrderDetail::select("order_details.*", DB::raw('SUM(qty) as tqty'))
        ->where('variant_id','=',$id)
        ->groupBy('variant_id')
        ->get();
        $lessqty =0;
        foreach($orderdetails as $orderdetail){
           $lessqty = $orderdetail->tqty;
        }
      $productvariant = ProductVariant::find($id);

      $productvariant->onhand = $addqty - $lessqty;
      $productvariant->save();

    }

}
