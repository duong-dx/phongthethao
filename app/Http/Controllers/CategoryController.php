<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Auth;
use \Yajra\Datatables\Datatables;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
{

    /**
         * Tác dụng : check middeware
         *
         * @param  name space
         * @param  int   biến chuyền vào
         * @return \Illuminate\Http\Response trả về gì
         */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('permission:show_category', ['only' => ['index', 'show']]);
        
        $this->middleware('permission:crud_category', ['only' => [ 'edit', 'store', 'update', 'destroy']]);
        

        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $categories = Category::get();
        return view('category.index',['categories'=>$categories]);

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
    public function store(CategoryRequest $request)
    {
    
       $category = new Category;
       $category->name = $request->name; 
       $category->thumbnail = $request->thumbnail;
       $category->description = $request->description; 
       
       $category->slug = $request->slug; 
       $category->parent_id= $request->parent_id;
       $category->save();
        return $category;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $category = Category::find($id);
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        Category::find($id)->update($request->all());
        $category = Category::find($id);
        return $category;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = Product::where('category_id', $id)->first();
        if($exists!=null){
            return response()->json([
                'error'=>true,
                'message'=>'Không thể xóa vì hiện tại có sản phẩm thuộc danh mục này!',
            ]);
        }

        Category::find($id)->delete();

        return response()->json([
                'error'=>false,
                'message'=>'Delete role success !',
            ]);
    }
    public function getCategories()
    {
        $categories= Category::orderBy('id','desc')->get();
        return datatables()->of($categories)->addColumn('action',function($categories){
            $data='';
            if(Auth::user()->can('show_category')){
              $data.= '<button  type="button" class="btn btn-info btn-show" data-id="'.$categories->id.'"><i class="far fa-eye"></i></button>';
            }
            if (Auth::user()->can('crud_category')) {
                $data .=
                '<button type="button" title="Cập nhật loại sản phẩm" class="btn  btn-warning btn-edit" data-id="'.$categories->id.'"><i class="far fa-edit"></i></button>
                <button type="button" title="Xóa tiết loại sản phẩm" class="btn btn-danger  btn-delete" data-id="'.$categories->id.'"><i class="far fa-trash-alt"></i></button>';
            }
            
            return $data;
             

        })
        ->editColumn('thumbnail',function($categories){
        return ''.$categories->thumbnail.'';
        })
        ->rawColumns(['action','thumbnail'])
         ->toJson();
    }
}
