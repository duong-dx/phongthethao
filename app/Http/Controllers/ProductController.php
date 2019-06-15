<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use App\Category;
use App\Brand;
use App\Image;
use App\Color;
use App\Branch;
use App\DetailProduct;
use App\DetailOrder;
use App\Memory;
use App\Review;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show_product', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_product', ['only' => ['store']]);
        $this->middleware('permission:update_product', ['only' => [ 'edit', 'update']]);
        $this->middleware('permission:delete_product', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::get();
         $categories = Category::get();
         $brands = Brand::get();
         $colors = Color::get();
         $branches = Branch::get();
         $memories = Memory::get();
        return view('product.index',['users'=>$users,'categories'=>$categories,'brands'=>$brands, 'colors'=>$colors,'branches'=>$branches, 'memories'=>$memories]);
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
    public function store(ProductStoreRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->price = $request->price;
        $product->sale = $request->sale;
        $product->quantity = $request->quantity;
        $product->branch_id = $request->branch_id;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->content = $request->content;
        $product->user_id = Auth::guard()->user()->id;
        $product->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::find($id);
        $images=Image::where('product_id',$id)->get();
        $user=User::find($product->user_id);
        $brand=Brand::find($product->brand_id);
        $branch=Branch::find($product->branch_id);
        $category=Category::find($product->category_id);
        return response()->json(['product'=>$product,'images'=>$images,'user'=>$user,'brand'=>$brand,'category'=>$category, 'branch' => $branch]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $product=Product::find($id);
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->price = $request->price;
        $product->sale = $request->sale;
        $product->quantity = $request->quantity;
        $product->branch_id = $request->branch_id;
        $product->brand_id = $request->brand_id;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->content = $request->content;
        $product->user_id = Auth::guard()->user()->id;
        $product->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $exists = DetailOrder::where('product_id',$id)->first();
  
        if($exists!=null){
            return response()->json([
                'error'=>true,
                'message'=>'Không thể xóa vì hiện tại sản phẩm đang được order !',
            ]);
        }
        Product::find($id)->delete();
        Image::where('product_id',$id)->delete();
        Review::where('product_id',$id)->delete();

        
    }

    // thêm mới ảnh cho sản phẩm
    public function addImages(Request $request){
        $image = $request->file('file');
        foreach ($image as $key => $value) {
            $imageName[]=$image[$key]->getClientOriginalName();
            $path =$value->storeAs('product_thumbnail',$image[$key]->getClientOriginalName());
            $imageUpload =  new Image;
            $imageUpload->thumbnail=$path;
            $imageUpload->product_id =$request->product_id;
            $imageUpload->save();

       }

    }

    // lấy danh sách sản phẩm và return về kiểu datatbale
    public function getProducts()
    {
        $products = DB::table('brands as b')
        ->join('products as p','p.brand_id','=','b.id')
        ->join('categories as c', 'c.id', '=', 'p.category_id')
        ->select('p.*', 'b.name as brand_name' , 'c.name as category_name')
        ->get();
        
        
       return datatables()->of($products)->addColumn('action',function( $products){
        $data='';
        if(Auth::user()->can('show_product')){
            $data.='<button type="button" title="Xem chi tiết" class="btn btn-info btn-show" data-id="'.$products->id.'"><i class="far fa-eye"></i></button>';
        }
        if(Auth::user()->can('show_review')){
            $data.='<button type="button" title="Reviews sản phẩm" class="btn btn-secondary btn-reviews" data-id="'.$products->id.'"><i class="far fa-file"></i></button>';
        }
         if(Auth::user()->can('update_product')){
            $data.='
            <button type="button" title="Thêm ảnh sản phẩm" class="btn btn-success btn-images" data-id="'.$products->id.'"><i class="far fa-images"></i></button>
            <button type="button" title="Chỉnh sửa thông tin" class="btn  btn-warning btn-edit" data-id="'.$products->id.'"><i class="far fa-edit"></i></button>';
         }
         if (Auth::user()->can('delete_product')) {
             $data.='<button type="button"  title="Xóa sản phẩm" class="btn btn-danger  btn-delete" data-id="'.$products->id.'"><i class="far fa-trash-alt"></i></button>';
         }
        
        return $data;
        })
       ->editColumn('price',function($products){
                
                    return ''.number_format($products->price).'';
               
         })
       
        ->editColumn('category_id',function($products){
                return ''.$products->category_name.'';
                })
        ->rawColumns(['action', 'category_id', 'price'])
        ->toJson();
    }


    // lấy ra danh sách sản phẩm cho phép khách hàng lựa chọn 
      public function getProductSale(){
        $products = DB::table('brands as b')
        ->join('products as p','p.brand_id','=','b.id')
        ->join('categories as c', 'c.id', '=', 'p.category_id')
        ->select('p.*', 'b.name as brand_name' , 'c.name as category_name')
        ->get();
        foreach ($products as $key => $product) {
            $product->thumbnail = DB::table('images')->where('product_id', $product->id)->first();
        }

        return datatables()->of($products)
       ->editColumn('choose',function($products){
                    return ' <button type="button" title="Thêm vào giỏ hàng" class="btn btn-info btn-add_to_cart" data-id="'.$products->id.'"><i class="fas fa-cart-plus"></i></button>';
         })
        ->editColumn('thumbnail',function($products){
                return '<img style="margin:auto; width:60px; height:60px;" src="/storage/'.$products->thumbnail->thumbnail.'">';
                })
        ->editColumn('brand_id',function($products){
                return ''.$products->brand_name.'';
                })
        ->editColumn('category_id',function($products){
                return ''.$products->category_name.'';
                })
        ->rawColumns(['brand_id','category_id','choose', 'thumbnail'])
        ->toJson();

    }

}
