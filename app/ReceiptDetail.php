<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ReceiptDetail extends Model
{
    //
    public function paymenttype()
    {
        return $this->belongsTo(PaymentType::class);
    }
}
