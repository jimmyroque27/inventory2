<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    //
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function productvariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    public function purchaseheader()
    {
        return $this->belongsTo(PurchaseHeader::class);
    }

}
