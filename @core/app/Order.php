<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = ['status','payment_status','custom_fields','attachment','package_name','package_price','package_id','user_id'];

    public function package(){
        return $this->hasOne('App\PricePlan','id','package_id');
    }

    public function gateway(){
        return $this->hasOne(PaymentLogs::class,'order_id');
    }

}
