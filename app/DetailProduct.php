<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailProduct extends Model
{
    protected $fillable =['product_id', 'color_id', 'price', 'sale_price', 'quantity', 'memory', 'branch_id'];
}
