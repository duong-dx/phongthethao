<?php

namespace App\Http\Controllers;
use App\Product;
use App\Order;
use Cart;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SaleRequest;
use Illuminate\Http\Request;

class SaleOnlineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::instance('shopping')->content();
        return view('shop.cart' , ['carts'=>$carts]);
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
    public function store(SaleRequest $request)
    {
        $product = DB::table('brands as b')
        ->join('products as p','p.brand_id','=','b.id')
        ->join('categories as c', 'c.id', '=', 'p.category_id')
        ->where('p.id',$request->product_id)
        ->select('p.*', 'b.name as brand_name' , 'c.name as category_name')
        ->first();
       
        $product->thumbnail = DB::table('images')->where('product_id', $product->id)->first();
       
        $carts =Cart::instance('shopping')->content();
       //check số lượng trừ đi số lượng đang order
        $sum=0;
         $detail_orders= Order::join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
            ->select('detail_orders.*')
            ->where('orders.status', '!=', 3)
            ->where('orders.status', '!=', 4)
            ->where('detail_orders.product_id',$request->product_id)
            ->get();
            
            foreach ($detail_orders as $key => $detail_order) {
                $sum +=$detail_order->quantity_buy;
            }

// check số lượng khi add mới
            if($request->quantity_buy>($product->quantity-$sum)){
                return response()->json([
                    'error'=>true,
                    'messages'=>'Số lượng bạn cần mua lớn hơn số lượng cửa hàng hiện có !'
                ]);
            }
// check số lượng khi đã tồn tại thì tổng số lượng không được phép lớn hơn số lượng tỏng kho
            $sum2=0;
            foreach ($carts as $key => $cart) {
             if($cart->id==$request->product_id){
                $sum2 +=$cart->qty;
                if(($cart->qty+$request->quantity_buy)>($product->quantity-$sum)){
                   return response()->json([
                    'error'=>true,
                    'messages'=>'Tổng số lượng bạn cần mua lớn hơn số lượng cửa hàng hiện có !'
                ]);
               }
           }
       }
        if($product->thumbnail!=null){
            Cart::instance('shopping')->add(['id' => $product->id, 'name' => $product->name, 'qty' => $request->quantity_buy, 'price' => ($product->price -($product->price*$product->sale)/100 ), 'options' => ['thumbnail'=>$product->thumbnail, 'price'=>$product->price, 'sale'=>$product->sale]]);
        }
        else{
            Cart::instance('shopping')->add(['id' => $product->id, 'name' => $product->name, 'qty' => $request->quantity_buy, 'price' => ($product->price -($product->price*$product->sale)/100 ), 'options' => ['thumbnail'=>'default_image.png', 'price'=>$product->price, 'sale'=>$product->sale]]);
        }
        // lấy ra số lượng sau khi add
         foreach ($carts as $key => $cart) {
             if($cart->id==$request->product_id){
                $sum2 =$cart->qty;
               
           }
       }
        $product_quantity = $product->quantity - $sum - $sum2;
        $count = Cart::instance('shopping')->count();
        $subtotal = Cart::instance('shopping')->subtotal();
        return response()->json([
                'error'=>false,
                'messages'=>'Add to cart success !',
                'count'=>$count,
                'subtotal'=>$subtotal,
                'product_quantity'=>$product_quantity,
                'sum'=>$sum,
                'sum2'=>$sum2,
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(['name'=>'đâsdsadadasdadada']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cart= Cart::instance('shopping')->get($id);
         //check số lượng trừ đi số lượng đang order
        $sum=0;
         $detail_orders= Order::join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
            ->select('detail_orders.*')
            ->where('orders.status', '!=', 3)
            ->where('orders.status', '!=', 4)
            ->where('detail_orders.product_id',$cart->id)
            ->get();
            
            foreach ($detail_orders as $key => $detail_order) {
                $sum +=$detail_order->quantity_buy;
            }

        $product = Product::find($cart->id);
        $product->quantity= ($product->quantity-$sum);

       
        return response()->json(['cart'=>$cart, 'product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaleRequest $request, $id)
    {
         $product= Product::find($request->product_id);
        $cart= Cart::instance('shopping')->get($id);
    //check số lượng trừ đi số lượng đang order ngoiaj trừ đã hủy vào đã thanh toán : thánh toán 3 và đã hủy là 4
         $sum=0;
         $detail_orders= Order::join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
            ->select('detail_orders.*')
            ->where('orders.status', '!=', 3)
            ->where('orders.status', '!=', 4)
            ->where('detail_orders.product_id',$request->product_id)
            ->get();
            
            foreach ($detail_orders as $key => $detail_order) {
                $sum +=$detail_order->quantity_buy;
            }
// check trừ đi số lượng đã order
        if($request->quantity_buy>($product->quantity-$sum)){
            return response()->json([
                'error'=>true,
                'messages'=>'Số lượng bạn cần mua lớn hơn số lượng cửa hàng hiện có !'
            ]);
        }

        Cart::instance('shopping')->update($id, $request->quantity_buy);
        $count = Cart::instance('shopping')->count();

        $new_cart= Cart::instance('shopping')->get($id);
        $total = Cart::instance('shopping')->subtotal();
        return response()->json([
                'error'=>false,
                'messages'=>'Update cart success !',
                'cart'=>$new_cart,
                'count'=>$count,
                'total'=>$total,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::instance('shopping')->remove($id);
        $total = Cart::instance('shopping')->subtotal();
        $count = Cart::instance('shopping')->count();
        return response()->json(['total'=>$total, 'count'=>$count]);
    }
    public function delete()
    {
         Cart::instance('shopping')->destroy();
         $count = Cart::instance('shopping')->count();
        $total = Cart::instance('shopping')->subtotal();
        return response()->json(['total'=>$total, 'count'=>$count]);
    }
}
