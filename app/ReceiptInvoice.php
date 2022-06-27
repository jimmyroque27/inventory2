<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ReceiptInvoice extends Model
{
    //
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function receiptheader()
    {
        return $this->belongsTo(ReceiptHeader::class);
    }
}
