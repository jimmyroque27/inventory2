<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PaymentPurchase extends Model
{
    //
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purchaseheader()
    {
        return $this->belongsTo(PurchaseHeader::class);
    }
}
