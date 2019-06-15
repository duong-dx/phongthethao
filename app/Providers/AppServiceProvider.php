<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use App\Category;
use App\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $products = DB::table('brands as b')
        // ->join('products as p','p.brand_id','=','b.id')
        // ->join('categories as c', 'c.id', '=', 'p.category_id')
        // ->select('p.*', 'b.name as brand_name' , 'c.name as category_name')
        // ->get();
        // $categories = Category::all();

        // foreach ($products as $key => $value) {
        //      $value->thumbnail = DB::table('images')->where('product_id',$value->id)->first();
             
        // }
        
        // View::share(['categories'=>$categories, 'products'=>$products]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
