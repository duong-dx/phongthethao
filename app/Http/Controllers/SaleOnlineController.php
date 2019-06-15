<?php

namespace App\Http\Controllers;
use App\DetailProduct;
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
        return view('shop.cart');
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
        $detail_product = DB::table('branches as b')
        ->join('detail_products as dp', 'dp.branch_id', '=', 'b.id')
        ->join('colors as c', 'dp.color_id', '=', 'c.id')
        ->join('products as p', 'dp.product_id', '=', 'p.id')
        ->join('memories as m', 'm.id', '=', 'dp.memory')
        ->where('dp.id', $request->detail_product_id)
        ->select('dp.*', 'b.name as branch_name', 'c.name as color_name','p.name as product_name' ,'m.name as memory_name')
         ->get()->first();
        
         
         $detail_product->thumbnail = DB::table('images')->where('product_id',$detail_product->product_id)->first()->thumbnail;
       
        $carts =Cart::instance('shopping')->content();
       //check số lượng trừ đi số lượng đang order
        $sum=0;
         $detail_orders= Order::join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
            ->select('detail_orders.*')
            ->where('orders.status', '!=', 3)
            ->where('orders.status', '!=', 4)
            ->where('detail_orders.detail_product_id',$request->detail_product_id)
            ->get();
            
            foreach ($detail_orders as $key => $detail_order) {
                $sum +=$detail_order->quantity_buy;
            }

// check số lượng khi add mới
        if($request->quantity_buy>($detail_product->quantity-$sum)){
            return response()->json([
                'error'=>true,
                'messages'=>'Số lượng bạn cần mua lớn hơn số lượng cửa hàng hiện có !'
            ]);
        }
// check số lượng khi đã tồn tại thì tổng số lượng không được phép lớn hơn số lượng tỏng kho
        foreach ($carts as $key => $cart) {
           if($cart->id==$request->detail_product_id){
                if(($cart->qty+$request->quantity_buy)>($detail_product->quantity-$sum)){
                     return response()->json([
                        'error'=>true,
                        'messages'=>'Tổng số lượng bạn cần mua lớn hơn số lượng cửa hàng hiện có !'
            ]);
                }
           }
        }

        
        Cart::instance('shopping')->add(['id' => $detail_product->id, 'name' => $detail_product->product_name, 'qty' => $request->quantity_buy, 'price' => $detail_product->sale_price, 'options' => ['memory' => $detail_product->memory_name, 'color'=>$detail_product->color_name, 'thumbnail'=>$detail_product->thumbnail]]);
        $count=Cart::instance('shopping')->count();
        return response()->json([
                'error'=>false,
                'messages'=>'Add to cart success !',
                'count'=>$count,
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
            ->where('detail_orders.detail_product_id',$cart->id)
            ->get();
            
            foreach ($detail_orders as $key => $detail_order) {
                $sum +=$detail_order->quantity_buy;
            }

        $detail_product = DetailProduct::find($cart->id);
        $detail_product->quantity= ($detail_product->quantity-$sum);

       
        return response()->json(['cart'=>$cart, 'detail_product'=>$detail_product]);
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
         $detail_product= DetailProduct::find($request->detail_product_id);
        $cart= Cart::instance('shopping')->get($id);
    //check số lượng trừ đi số lượng đang order ngoiaj trừ đã hủy vào đã thanh toán : thánh toán 3 và đã hủy là 4
         $sum=0;
         $detail_orders= Order::join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
            ->select('detail_orders.*')
            ->where('orders.status', '!=', 3)
            ->where('orders.status', '!=', 4)
            ->where('detail_orders.detail_product_id',$request->detail_product_id)
            ->get();
            
            foreach ($detail_orders as $key => $detail_order) {
                $sum +=$detail_order->quantity_buy;
            }
// check trừ đi số lượng đã order
        if($request->quantity_buy>($detail_product->quantity-$sum)){
            return response()->json([
                'error'=>true,
                'messages'=>'Số lượng bạn cần mua lớn hơn số lượng cửa hàng hiện có !'
            ]);
        }

        Cart::instance('shopping')->update($id, $request->quantity_buy);
        
        $new_cart= Cart::instance('shopping')->get($id);
        $total = Cart::instance('shopping')->subtotal();
        return response()->json([
                'error'=>false,
                'messages'=>'Update cart success !',
                'cart'=>$new_cart,
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
        return response()->json(['total'=>$total]);
    }
    public function delete()
    {
         Cart::instance('shopping')->destroy();
         
        $total = Cart::instance('shopping')->subtotal();
        return response()->json(['total'=>$total]);
    }
}
