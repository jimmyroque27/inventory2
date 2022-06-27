<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    //
    public function paymentheader()
    {
        return $this->belongsTo(PaymentHeader::class);
    }
}
