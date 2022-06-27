<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $dates = [
        'buying_date', 'expire_date',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purchasedetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
