<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
  protected $fillable = [
      'name'
  ];

  public function paymentdetails()
  {
      return $this->hasMany(PaymentDetail::class);
  }
  public function receipt_details()
  {
      return $this->hasMany(ReceiptDetail::class);
  }
}
