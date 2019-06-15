<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Customer extends Authenticatable
{
	use Notifiable;
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =['name', 'email', 'password', 'birthday', 'mobile', 'thumbnail', 'address', 'level_id'];

     /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];
}
