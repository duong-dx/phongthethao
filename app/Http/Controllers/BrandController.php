<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Product;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use App\Http\Requests\BrandUpdateRequest;

class BrandController extends Controller
{
    /**
         * Tác dụng :Khởi tạo
         *
         * @param  name space
         * @param  int   biến chuyền vào
         * @return \Illuminate\Http\Response trả về gì
         */
    public function __construct()
    {
         $this->middleware('auth');

        $this->middleware('permission:show_brand', ['only' => ['index', 'show']]);
        
        $this->middleware('permission:crud_brand', ['only' => [ 'edit', 'store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('brand.index');
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
    public function store(BrandRequest $request)
    {
        $path = $request->thumbnail->storeAs('brand_thumbnail',$request->thumbnail->getClientOriginalName());
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->thumbnail = $path;
        $brand->origin = $request->origin;
        $brand->save();
        return $brand;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $brand= Brand::find($id);
        return $brand;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandUpdateRequest $request,$id)
    {
         $path = $request->thumbnail->storeAs('brand_thumbnail',$request->thumbnail->getClientOriginalName());
        $brand =  Brand::find($id);
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->thumbnail = $path;
        $brand->origin = $request->origin;
        $brand->save();
        $new_brand= Brand::find($id);
        return $new_brand;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = Product::where('brand_id', $id)->first();
        if($exists!=null){
            return response()->json([
                'error'=>true,
                'message'=>'Không thể xóa vì hiện tại có sản phẩm thuộc hãng này !',
            ]);
        }
        Brand::find($id)->delete();

        return response()->json([
                'error'=>false,
                'message'=>'Delete role success !',
            ]);
    }
    public function getBrands()
    {
        $brands = Brand::get();
        return datatables()->of($brands)->addColumn('action', function($brands){
             if(Auth::user()->can('crud_color')){ 
                return '
                <button type="button" class="btn  btn-warning btn-edit" data-id="'.$brands->id.'"><i class="far fa-edit"></i></button>
                <button type="button" class="btn btn-danger  btn-delete" data-id="'.$brands->id.'"><i class="far fa-trash-alt"></i></button>';
            }else
            {
                return 'Bạn không có quyền hạn trên tác vụ này ';
            }
            })
       ->editColumn('thumbnail',function($brands){
        return '<img style="margin:auto; width:60px; height:40px;" src ="/storage/'.$brands->thumbnail.'">';
        })
        ->rawColumns(['action','thumbnail'])
        ->toJson();
    }
}
