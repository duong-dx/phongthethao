<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'status', 'sale', 'price', 'quantity', 'category_id', 'description', 'content', 'view_count', 'quantity_sold', 'user_id', 'branch_id', 'brand_id'];
}
