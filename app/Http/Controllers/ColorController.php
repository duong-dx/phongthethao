<?php

namespace App\Http\Controllers;

use App\Color;
use Auth;
use App\DetailProduct;
use Illuminate\Http\Request;
use App\Http\Requests\ColorRequest;
class ColorController extends Controller
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

        $this->middleware('permission:show_color', ['only' => ['index', 'show']]);
        
        $this->middleware('permission:crud_color', ['only' => [ 'edit', 'store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('color.index');
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
    public function store(ColorRequest $request)
    {
         $color = Color::create($request->all());
        return $color;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $color = Color::find($id);
        return $color;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(ColorRequest $request, $id)
    {
        $color = Color::find($id)->update($request->all());
        $new_color = Color::find($id);
        return $new_color;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = DetailProduct::where('color_id', $id)->first();
        if($exists!=null){
            return response()->json([
                'error'=>true,
                'message'=>'Không thể xóa vì hiện tại có sản phẩm thuộc danh mục này!',
            ]);
        }
        Color::find($id)->delete();
        return response()->json([
                'error'=>false,
                'message'=>'Delete role success !',
            ]);
    }
    public function getColors()
    {
        $colors= Color::all();
        return datatables()->of($colors)->addColumn('action', function($colors){
           if(Auth::user()->can('crud_color')){ 
                return '
                <button type="button" class="btn btn-warning btn-edit" title="Cập nhật thông tin màu sắc" data-id="'.$colors->id.'"><i class="far fa-edit"></i></button>
                <button title="Xóa màu sắc" type="button" class="btn btn-danger  btn-delete" data-id="'.$colors->id.'"><i class="far fa-trash-alt"></i></button>';
            }
            else{
                return'Bạn không có quyền hạn trên tác vụ này';
            }
        })
       ->editColumn('code',function($colors){
        return '<div style="width:30px; height:30px; background:'.$colors->code.'; margin:auto;"></div>';
        })
        ->rawColumns(['action','code'])
        ->toJson();
    }
}
