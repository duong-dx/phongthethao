<?php

namespace App\Http\Controllers;

use App\Order;
use App\DetailOrder;
use App\DetailProduct;
use App\Status;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Validations\Validation;
use Illuminate\Support\Facades\DB;
use Cart;
use Mail;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = Status::all();
        return view('order.index', ['statuses'=>$statuses]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {

        if($request->customer_id!=null){
            $rule=
            [
                'customer_id'=>['numeric', 'exists:customers,id'],
                'customer_email'=>'email',
                ];
            $message=
            [
                'customer_id.numeric'=>'Mã khách hàng phải là số !',
                'customer_id.exists'=>'Khách hàng này không tồn tại !',
                'customer_email.email'=>'Email phải đúng định dạng email !',
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
       
        $count_cart=Cart::instance('admin')->count();
        
        if($count_cart==0){
            return response()->json(['error_cart'=>true,'message'=>'Giỏ hàng rỗng ! Vui lòng chọn sản phẩm',200]);
        }
        $carts = Cart::instance('admin')->content();
        // check cart rỗng 
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

         $total_cart =Cart::instance('admin')->subtotal();
            
        if($order->customer_email!=null){
            //dd($order);
            Mail::send('mail.bill', compact('order', 'carts', 'total_cart'), function($message) use ($order){
            $message->to($order->customer_email,$order->customer_name)->subject('Hóa đơn mua hàng !');
            });
        }

         Cart::instance('admin')->destroy();
         return $order;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        return $order;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return $order;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateRequest $request, $id)
    {
        if($request->status==4){
            $rule=
            [
                'reason_reject'=>'required|min:10|max:255',
                ];
            $message=
            [
                'reason_reject.required'=>'Lý do không được bỏ trống !',
                'reason_reject.min'=>'Lý do tối đa là 10 ký tự !',
                'reason_reject.max'=>'Lý do tối đa là 255 ký tự !',
            ];
            $validator = \Validator::make($request->all(), $rule, $message);
            if( $validator->fails()){
                return response()->json(['error'=>true,'messages'=>$validator->errors(),200]);
            }
            $order = Order::find($id)->update($request->all());
        }
        elseif($request->status==3){
            $order = Order::find($id);
            $order->status=$request->status;
            $order->reason_reject=$request->reason_reject;
            $order->save();
            //lấy danh sách detail_order
            $detail_orders=DetailOrder::where('order_id',$id)->get();

            foreach ($detail_orders as $key => $detail_order) {
                // lấy ra sản detail_product trừ số lượng
                $detail_product = DetailProduct::find($detail_order->detail_product_id);
                $detail_product->quantity= ($detail_product->quantity-$detail_order->quantity_buy);
                $detail_product->save();

                // lấy ra product tăng số lượng
                $product= Product::find($detail_product->product_id);
                $product->quantity_sold= ($product->quantity_sold+$detail_order->quantity_buy);
                $product->save();
            }

            
        }else{
             $order = Order::find($id);
             $order->status=$request->status;
             $order->reason_reject=$request->reason_reject;
             $order->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
    public function getOrders(){
        $orders = Order::join('statuses', 'orders.status', '=', 'statuses.code')
        ->select('orders.*', 'statuses.name as status_name')
        ->orderBy('orders.id', 'desc');


        return datatables()->of($orders)->addColumn('action', function($orders){
          
               $data='';
                if($orders->status!=4){
                    $data.='
                    <button type="button" class="btn btn-default btn-bill" title="Tạo hóa đơn" data-id="'.$orders->id.'"><i class="fas fa-file-alt"></i></button>';
                }
                 $data .='
                <button type="button" class="btn btn-info btn-detail_orders" title="Xem chi tiết đơn hàng" data-id="'.$orders->id.'"><i class="far fa-eye"></i></button>';
                if($orders->status==4){
                    $data.='<button type="button" class="btn btn-danger btn-reason_reject" title="Lý do hủy" data-id="'.$orders->id.'"><i class="far fa-eye-slash"></i></button>';
                }
                if($orders->status!=3){
                    $data.='<button title="Cập nhật trạng thái" type="button" class="btn btn-warning  btn-edit" data-id="'.$orders->id.'"><i class="far fa-edit"></i></button>';
                }


                return $data;
           
        })
       ->editColumn('status', function($orders){
                if($orders->status==4){
                     return '<p class="text-danger">'.$orders->status_name.'</p>';
                }
                elseif($orders->status==3){
                    return '<p class="text-success" >'.$orders->status_name.'</p>';
                }
                else{
                    return $orders->status_name;
                }
           
       
       })
       ->editColumn('customer_mobile', function($orders){
            return '<a href="tel:'.$orders->customer_mobile.'" ><i class="fas fa-phone-square"></i> &nbsp'.$orders->customer_mobile.'</a>';
       })
        ->rawColumns(['action', 'status', 'customer_mobile'])
        ->toJson();
    }
    public function getBill($id)
    {
         $order = Order::find($id);
        
        // get detail
        $detail_order = DB::table('detail_orders as do')
        ->join('orders as o', 'o.id', '=', 'do.order_id')
        ->join('detail_products as dp', 'dp.id', '=', 'do.detail_product_id')
        ->join('memories as m', 'm.id', '=', 'dp.memory')
        ->join('colors as c', 'c.id', '=', 'dp.color_id')
        ->join('products as p', 'p.id', '=', 'dp.product_id')
        ->join('statuses as st', 'st.code', '=', 'o.status')
        ->select('do.*', 'o.*','p.name as product_name', 'p.id as product_id', 'm.name as memory', 'c.name as color_name')
        ->where('o.id', $id)
        ->get();
        return response()->json(['detail_order'=>$detail_order, 'order'=>$order]);
    }
}
