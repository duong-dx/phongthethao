<?php

namespace App\Http\Controllers\CustomerAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use App\Social;
use App\Customer;
use Auth;
class SocialiteController extends Controller
{
   /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $customer = Socialite::driver('facebook')->user();
        
        $social = Social::where('provider_customer_id',$customer->id)->where('provider','facebook')->first();
        if($social){
            $cus = Customer::where('code',$customer->id)->first();
            Auth::guard('customer')->login($cus);
            return redirect('/');
        }
        else{
            $new_social = new Social;
            $new_social->provider_customer_id= $customer->id;
            $new_social->provider='facebook';
            // check xem có thằng khách hàng có code bằng $customer->id chưa ;
             $cus = Customer::where('code',$customer->id)->first();
            // nếu chưa có thì tạo mới 
             if(!$cus){
                $c = new Customer;
                 $c->code=$customer->id;
                $c->name=$customer->name;
                $c->email= $customer->email;
                $c->save();
             }
             $new_social->customer_id = $c->id;
             $new_social->save();
             Auth::guard('customer')->login($c);
             return redirect('/');
        }
    }
}
