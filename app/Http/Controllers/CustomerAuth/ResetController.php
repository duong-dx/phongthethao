<?php

namespace App\Http\Controllers\CustomerAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetRequest;
use App\Validations\Validation;
use App\Customer;
use Mail;
use Illuminate\Support\Facades\Hash;
class ResetController extends Controller
{
    public function reset(ResetRequest $request)
    {
    	$customer = Customer::where('email',$request->email)->first();
    	$password=str_random(6);
    	$customer->password = Hash::make($password);
    	$customer->save();
    	 Mail::send('mail.resetpassword', ['password' => $password], function($message) use ($customer){
            $message->to($customer->email,$customer->name)->subject('Reset Password');
         });
    }
}
