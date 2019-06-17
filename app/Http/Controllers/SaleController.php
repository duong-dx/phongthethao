<?php

namespace App\Http\Controllers;
use App\Order;
use Cart;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('sale.index');
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
        
        $carts =Cart::instance('admin')->content();
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
        foreach ($carts as $key => $cart) {
           if($cart->id==$request->product_id){
                if(($cart->qty+$request->quantity_buy)>($product->quantity-$sum)){
                     return response()->json([
                        'error'=>true,
                        'messages'=>'Tổng số lượng bạn cần mua lớn hơn số lượng cửa hàng hiện có !'
            ]);
                }
           }
        }

        if($product->thumbnail!=null){
            Cart::instance('admin')->add(['id' => $product->id, 'name' => $product->name, 'qty' => $request->quantity_buy, 'price' => ($product->price -($product->price*$product->sale)/100 ), 'options' => ['thumbnail'=>$product->thumbnail->thumbnail, 'price'=>$product->price, 'sale'=>$product->sale]]);
        }
        else{
         
            Cart::instance('admin')->add(['id' => $product->id, 'name' => $product->name, 'qty' => $request->quantity_buy, 'price' => ($product->price -($product->price*$product->sale)/100 ), 'options' => ['thumbnail'=> 'default_image.png', 'price'=>$product->price, 'sale'=>$product->sale]]);
        }
        
        $count = Cart::instance('admin')->count();
        $subtotal = Cart::instance('admin')->subtotal();
        return response()->json([
                'error'=>false,
                'messages'=>'Add to cart success !',
                'count'=>$count,
                'subtotal'=>$subtotal,
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
        //check số lượng trừ đi số lượng đang order
            $sum=0;
         $detail_orders= Order::join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
            ->select('detail_orders.*')
           ->where('orders.status', '!=', 3)
            ->where('orders.status', '!=', 4)
            ->where('detail_orders.product_id',$id)
            ->get();
            
            foreach ($detail_orders as $key => $detail_order) {
                $sum +=$detail_order->quantity_buy;
            }

            //check số lượng khách hàng đã thêm vào giỏ hàng là bao nhiêu 
            $carts =Cart::instance('admin')->content();
            $sum2=0;
            foreach ($carts as $key => $cart) {
               if($cart->id==$id){
                    $sum2+= $cart->qty;  
                }
            }
            // tìm sản phẩm theo id truyền vào
         $product= Product::find($id);
// trừ đi số lượng đã được order VÀ SỐ Lượng đã thêm vào giỏ hàng
         $product->quantity= ($product->quantity-$sum-$sum2);
         return $product;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cart= Cart::instance('admin')->get($id);
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
        $cart= Cart::instance('admin')->get($id);
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

        if($request->quantity_buy>($product->quantity-$sum)){
            return response()->json([
                'error'=>true,
                'messages'=>'Số lượng bạn cần mua lớn hơn số lượng cửa hàng hiện có !'
            ]);
        }

        Cart::instance('admin')->update($id, $request->quantity_buy);
         $subtotal = Cart::instance('admin')->subtotal();
        return response()->json([
                'error'=>false,
                'messages'=>'Update cart success !',
                'subtotal'=>$subtotal,
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
        Cart::instance('admin')->remove($id);
         $subtotal = Cart::instance('admin')->subtotal();
        return $subtotal;
    }
    // xóa toàn bộ giỏi hàng
    public function delete(){
        
        Cart::instance('admin')->destroy();

       
    }
    public function getSubtotalCart(){
        $subtotal = Cart::instance('admin')->subtotal();
        return $subtotal;
    }

    public function getCart()
    {
        $cart= Cart::instance('admin')->content();
        // dd($cart);
        // return view('sale.cart');
        return datatables()->of($cart)
       ->addColumn('action',function($cart){
        return '
         <button type="button" title="Cập nhật số lượng mua" class="btn btn-warning btn-update_cart" data-id="'.$cart->rowId.'"><i class="far fa-edit"></i></button>
         <button type="button" title="Hủy sản phẩm" class="btn btn-danger btn-delete" data-id="'.$cart->rowId.'"><i class="far fa-trash-alt"></i></button>';
         })
       ->editColumn('id',function($cart){
                return ''.$cart->id.'';
                })
       ->editColumn('product_name',function($cart){
                return ''.$cart->name.'';
                })
       ->editColumn('quantity_buy',function($cart){
                return ''.$cart->qty.'';
                })
       ->editColumn('sale_price',function($cart){
                return ''.number_format($cart->price).' VNĐ';
                })
       ->editColumn('sale',function($cart){
                return '<p style="color:green">Giảm giá: '.$cart->options->sale.' %</p>';
                })
        ->editColumn('thumbnail',function($cart){
                return '<img style="margin:auto; width:60px; height:60px;" src ="/storage/'.$cart->options->thumbnail.'">';
                })
        ->rawColumns(['action','product_name', 'sale_price', 'quantity_buy', 'thumbnail', 'sale'])
        ->toJson();
    }
}
