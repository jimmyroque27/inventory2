<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ReceiptHeader extends Model
{
    //
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
