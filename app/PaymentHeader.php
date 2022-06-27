<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PaymentHeader extends Model
{
    //
    //
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function paymentdetails()
    {
        return $this->hasMany(PaymentDetail::class);
    }
    public function paymentpurchases()
    {
        return $this->hasMany(PaymentPurchase::class);
    }
}
