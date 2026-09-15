<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLogs extends Model
{
    use HasFactory;
    protected $table = 'payment_logs';
    protected $fillable = ['email','name','package_name','package_price','package_gateway','order_id','status','track','transaction_id'];


  public function order(){
      return $this->belongsTo(Order::class);
  }


}
