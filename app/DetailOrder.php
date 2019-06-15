<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $fillable=['order_id', 'detail_product_id', 'sale_price', 'quantity_buy', 'total'];
}
