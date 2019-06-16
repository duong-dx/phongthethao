<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Product;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         $products = DB::table('brands as b')
        ->join('products as p','p.brand_id','=','b.id')
        ->join('categories as c', 'c.id', '=', 'p.category_id')
        ->select('p.*', 'b.name as brand_name' , 'c.name as category_name')
        ->get();
        foreach ($products as $key => $value) {
             $value->thumbnail = DB::table('images')->where('product_id',$value->id)->first();
             
        }
        return view('shop.home', ['products' => $products]);
    }
}
