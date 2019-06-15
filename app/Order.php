<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $fillable = ['code', 'customer_name', 'customer_address', 'customer_mobile', 'status', 'customer_id', 'user_id', 'coupon_code', 'reason_reject','customer_email'];
}
