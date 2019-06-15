<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\User;
use App\Product;
use App\Order;
use DB;

class StatisticalController extends Controller
{
    public function index(){
    	$customer_count = Customer::all()->count();
    	$user_count = User::all()->count();
    	$product_count = Product::all()->count();
    	$order_paid_count= Order::where('status',3)->count();
    	$order_confirm_count= Order::where('status',0)->count();
    	$order_canceled_count= Order::where('status',4)->count();
    	
    	return view('statistical.index',['customer_count'=>$customer_count, 'user_count'=>$user_count, 'product_count'=>$product_count, 'order_confirm_count'=>$order_confirm_count, 'order_canceled_count'=>$order_canceled_count, 'order_paid_count'=>$order_paid_count]);
    }
}
