<?php

namespace App\Http\Controllers;

use App\DetailProduct;
use App\Order;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\DetailProductStoreRequest;

class DetailProductController extends Controller
{
    /**
         * Tác dụng :khowri tạo check middweare
         *
         * @param  name space
         * @param  int   biến chuyền vào
         * @return \Illuminate\Http\Response trả về gì
         */
    public function __construct()
    {
         

        $this->middleware('permission:show_detail_product', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_detail_product', ['only' => ['store']]);
        $this->middleware('permission:update_detail_product', ['only' => [ 'edit', 'update']]);
        $this->middleware('permission:delete_detail_product', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(DetailProductStoreRequest $request)
    {
       $detail_product_add=DetailProduct::create($request->all());
       return $detail_product_add;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailProduct  $detailProduct
     * @return \Illuminate\Http\Response
     */
    public function show(DetailProduct $detailProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailProduct  $detailProduct
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $detail_product = DetailProduct::find($id);
        return $detail_product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailProduct  $detailProduct
     * @return \Illuminate\Http\Response
     */
    public function update(DetailProductStoreRequest $request, $id)
    {
        $detail_product = DetailProduct::find($id)->update($request->all());
        $new_detail_product =DetailProduct::find($id);
        return $new_detail_product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailProduct  $detailProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DetailProduct::find($id)->delete();
    }
    public function getDetailProducts($id){
        $detail_products = DB::table('branches as b')
        ->join('detail_products as dp', 'dp.branch_id', '=', 'b.id')
        ->join('colors as c', 'dp.color_id', '=', 'c.id')
        ->join('products as p', 'dp.product_id', '=', 'p.id')
        ->join('memories as m', 'm.id', '=', 'dp.memory')
        ->where('dp.product_id', $id)
        ->select('dp.*', 'b.name as branch_name', 'c.name as color_name','p.name as product_name' ,'m.name as memory')
        ->get();
        
        if($detail_products!=null){
             return datatables()->of($detail_products)
             ->editColumn('product_name',function($detail_products){
                return ''.$detail_products->product_name.'';
                })
             ->editColumn('color_name',function($detail_products){
                return ''.$detail_products->color_name.'';
                })
             ->editColumn('sale_price',function($detail_products){
                return ''.number_format($detail_products->sale_price).'';
                })
            ->addColumn('action',function($detail_products){
                $data='';
                if(Auth::user()->can('update_detail_product')){
                     $data .='
                         <button type="button" title="Chỉnh sửa thông tin" class="btn  btn-warning btn-edit-detail-product" data-id="'.$detail_products->id.'"><i class="far fa-edit"></i></button>';
                }
                
                if(Auth::user()->can('delete_detail_product')){
                    $data .='
                
                <button type="button"  title="Xóa sản phẩm" class="btn btn-danger  btn-delete-detail-product" data-id="'.$detail_products->id.'"><i class="far fa-trash-alt"></i></button>';
                }
                return $data;
                
                
            })
            ->rawColumns(['product_name', 'action', 'color_name'])
            ->toJson();
            
        }
    }
    public function getDetailProductSale($id){
         $detail_products = DB::table('branches as b')
        ->join('detail_products as dp', 'dp.branch_id', '=', 'b.id')
        ->join('colors as c', 'dp.color_id', '=', 'c.id')
        ->join('products as p', 'dp.product_id', '=', 'p.id')
        ->join('memories as m', 'm.id', '=', 'dp.memory')
        ->where('dp.product_id', $id)
        ->select('dp.*', 'b.name as branch_name', 'c.name as color_name','p.name as product_name' ,'m.name as memory')
        ->get();


        return datatables()->of($detail_products)
             ->editColumn('product_name',function($detail_products){
                return ''.$detail_products->product_name.'';
                })
             ->editColumn('color_name',function($detail_products){
                return ''.$detail_products->color_name.'';
                })
             ->editColumn('sale_price',function($detail_products){
                return ''.number_format($detail_products->sale_price).'';
                })
            ->addColumn('action',function($detail_products){
               return '<button type="button" title="Thêm vào giỏ hàng" class="btn  btn-info btn-add_to_cart" data-id="'.$detail_products->id.'">Add To Cart &nbsp<i class="fas fa-dolly"></i></button>';
                
            })
            ->rawColumns(['product_name', 'action', 'color_name'])
            ->toJson();
    }
    public function getDP($slug,$memory,$color_id)
    {
        //check số lượng oder
        

        $detail_product = DB::table('products as p')
        ->join('detail_products as dp', 'dp.product_id', '=', 'p.id')
        ->join('memories as m', 'm.id', '=', 'dp.memory')
        ->join('colors as c', 'c.id', '=', 'dp.color_id')
        ->where('m.id',$memory)
        ->where('p.slug',$slug)
        ->where('dp.color_id',$color_id)
        ->select('c.name as color_name', 'dp.*')
        ->get()->first();

         $sum=0;
         $detail_orders= Order::join('detail_orders', 'orders.id', '=', 'detail_orders.order_id')
            ->select('detail_orders.*')
           ->where('orders.status', '!=', 3)
            ->where('orders.status', '!=', 4)
            ->where('detail_orders.detail_product_id',$detail_product->id)
            ->get();  
        foreach ($detail_orders as $key => $detail_order) {
                $sum +=$detail_order->quantity_buy;
        }
        
         $detail_product->quantity= ($detail_product->quantity-$sum);
        return response()->json(['detail_product'=>$detail_product]);
    }
    
}
