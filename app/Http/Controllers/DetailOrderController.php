<?php

namespace App\Http\Controllers;

use App\DetailOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DetailOrderController extends Controller
{
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetailOrder  $detailOrder
     * @return \Illuminate\Http\Response
     */
    public function show(DetailOrder $detailOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetailOrder  $detailOrder
     * @return \Illuminate\Http\Response
     */
    public function edit(DetailOrder $detailOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetailOrder  $detailOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailOrder $detailOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetailOrder  $detailOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailOrder $detailOrder)
    {
        //
    }
    public function getDetailOrder($id)
    {
       $detail_order = DB::table('detail_orders as do')
        ->join('orders as o', 'o.id', '=', 'do.order_id')
        ->join('products as p', 'p.id', '=', 'do.product_id')
        ->select('do.*', 'o.*','p.name as product_name', 'p.id as product_id')
        ->where('o.id', $id)
        ->get();
        foreach ($detail_order as $key => $value) {
            $value->thumbnail = DB::table('images')->where('product_id', $value->product_id)->first()->thumbnail;
        }

        // return datatbales

         return datatables()->of($detail_order)
         ->editColumn('thumbnail', function($detail_order){
                 return '<img style="margin:auto; width:60px; height:60px;" src ="/storage/'.$detail_order->thumbnail.'">';
        })
         ->editColumn('sale_price', function($detail_order){
            return ''.number_format($detail_order->sale_price).' VNĐ';
       })
       ->editColumn('total', function($detail_order){
            return ''.number_format($detail_order->sale_price*$detail_order->quantity_buy).'  VNĐ';
       })
        ->rawColumns(['action', 'total', 'thumbnail', 'sale_price'])
        ->toJson();
    }
}
