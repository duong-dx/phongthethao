<?php

namespace App\Http\Controllers;

use App\Memory;
use Auth;
use App\DetailProduct;
use Illuminate\Http\Request;
use App\Http\Requests\MemoryRequest;

class MemoryController extends Controller
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

        $this->middleware('permission:show_memory', ['only' => ['index', 'show']]);
        
        $this->middleware('permission:crud_memory', ['only' => [ 'edit', 'store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('memory.index');
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
    public function store(MemoryRequest $request)
    {
       $memory = Memory::create($request->all());
       return $memory;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function show(Memory $memory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $memory = Memory::find($id);
        return $memory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function update(MemoryRequest $request, $id)
    {
        $memory = Memory::find($id)->update($request->all());
        $new_memory = Memory::find($id);
        return $new_memory;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $exists = DetailProduct::where('memory', $id)->first();
        if($exists!=null){
            return response()->json([
                'error'=>true,
                'message'=>'Không thể xóa vì hiện tại có sản phẩm thuộc danh mục này!',
            ]);
        }
         Memory::find($id)->delete();
         return response()->json([
                'error'=>false,
                'message'=>'Delete role success !',
            ]);
    }

    public function getMemories(){
         $memories= Memory::get();
        
        return datatables()->of($memories)->addColumn('action', function($memories){
             if(Auth::user()->can('crud_memory')){ 
                return '
                <button type="button" title="Cập nhật dung lượng sản phẩm " class="btn  btn-warning btn-edit" data-id="'.$memories->id.'"><i class="far fa-edit"></i></button>
                <button title="Xóa dung lượng" type="button" class="btn btn-danger  btn-delete" data-id="'.$memories->id.'"><i class="far fa-trash-alt"></i></button>';
            }
            else{
                return 'Bạn không có quyền hạn trên tác vụ này';
            }
        })
        ->rawColumns(['action'])
        ->toJson();
    }
}
