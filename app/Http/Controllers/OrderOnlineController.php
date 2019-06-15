<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validations\Validation;
use Illuminate\Support\Facades\DB;
use Cart;
use App\Http\Requests\OrderRequest;
use App\Order;
use Mail;
use App\DetailOrder;
use App\DetailProduct;
use App\Product;
class OrderOnlineController extends Controller
{
    public function store(OrderRequest $request)
    {
    	// dd($request->all());

        if($request->customer_id!=null){
            $rule=
            [
                'customer_id'=>['numeric', 'exists:customers,id'],
                
                ];
            $message=
            [
                'customer_id.numeric'=>'Mã khách hàng phải là số !',
                'customer_id.exists'=>'Khách hàng này không tồn tại !',
                
            ];
            $validator = \Validator::make($request->all(), $rule, $message);
            if( $validator->fails()){
                return response()->json(['error'=>true,'messages'=>$validator->errors(),200]);
            }
        }
        if($request->customer_email!=null){
            $rule=['customer_email'=>'email',];
            $message=['customer_email.email'=>'Email phải đúng định dạng email !',];
            $validator = \Validator::make($request->all(), $rule, $message);
            if( $validator->fails()){
                return response()->json(['error'=>true,'messages'=>$validator->errors(),200]);
            }
        }
        
        if($request->user_id!=null){
            $rule=
            [
                'user_id'=>['numeric', 'exists:users,id'],
            ];
            $message=
            [
                'user_id.numeric'=>'Mã nhân viên phải là số !',
                'user_id.exists'=>'Nhân viên không tồn tại này không tồn tại !',
                
            ];
            $validator = \Validator::make($request->all(), $rule, $message);
            if( $validator->fails()){
                return response()->json(['error'=>true,'messages'=>$validator->errors(),200]);
            }
        }
       // check cart rỗng 
        $count_cart=Cart::instance('shopping')->count();
        
        if($count_cart==0){
            return response()->json(['error_cart'=>true,'message'=>'Giỏ hàng rỗng ! Vui lòng chọn sản phẩm',200]);
        }

        $carts = Cart::instance('shopping')->content();
        
         //Check xem có số lượng đã đặt mua có 
        $message2s=array();
        
        foreach ($carts as $key => $cart) {
          $sum=0;
           $detail_orders= Order::join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
            ->select('detail_orders.*')
            ->where('orders.status', '!=', 3)
            ->where('orders.status', '!=', 4)
            ->where('detail_orders.detail_product_id',$cart->id)
            ->get();
            
            foreach ($detail_orders as $key => $detail_order) {
                $sum +=$detail_order->quantity_buy;
            }
            $detail_product=DetailProduct::find($cart->id);
            if(($cart->qty+$sum)>$detail_product->quantity){
                $row=array();
                $row['quantity']=($detail_product->quantity-$sum);
                $row['cart_name']=$cart->name;
                $row['cart_id']=$cart->id;
                $message2s[]=$row;
               
            }
        }
        if($message2s!=null){
            return response()->json(['error_quantity'=>true, 'messages'=>$message2s]);
        }

        
        $order = new Order;
        $order->code= time().'.Royal';
        $order->customer_name=$request->customer_name;
        $order->customer_address=$request->customer_address;
        $order->customer_mobile=$request->customer_mobile;
        $order->customer_id=$request->customer_id;
        $order->customer_email=$request->customer_email;
        $order->user_id=$request->user_id;
        $order->save();
         foreach ($carts as $key => $cart) {
             $detail_order = new DetailOrder;
             $detail_order->detail_product_id= $cart->id;
             $detail_order->order_id= $order->id;
             $detail_order->sale_price= $cart->price;
             $detail_order->quantity_buy= $cart->qty;
             $detail_order->total= ($cart->qty*$cart->price);
             $detail_order->save();
         }

         $total_cart =Cart::instance('shopping')->subtotal();
            
        if($order->customer_email!=null){
            //dd($order);
            Mail::send('mail.bill', compact('order', 'carts', 'total_cart'), function($message) use ($order){
            $message->to($order->customer_email,$order->customer_name)->subject('Hóa đơn mua hàng !');
            });
        }

         Cart::instance('shopping')->destroy();
         return $order;

    }
}
