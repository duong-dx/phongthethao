<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $fillbale=['customer_id', 'provider_customer_id', 'provider'];

    public function customers(){
    	return $this->belongsTo(Customer::class);
    }
}
