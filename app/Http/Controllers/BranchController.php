<?php

namespace App\Http\Controllers;

use App\Branch;
use App\DetailProduct;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\BranchRequest;

class BranchController extends Controller
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

        $this->middleware('permission:show_branch', ['only' => ['index', 'show', 'getBranches']]);
        
        $this->middleware('permission:crud_branch', ['only' => [ 'edit', 'store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('branch.index');
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
    public function store(BranchRequest $request)
    {
        $branch = Branch::create($request->all());
        return $branch;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $branch = Branch::find($id);
       return $branch;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(BranchRequest $request, $id)
    {
        $branch = Branch::find($id)->update($request->all());
        $new_branch = Branch::find($id);
        return $new_branch;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = DetailProduct::where('branch_id', $id)->first();
        if($exists!=null){
            return response()->json([
                'error'=>true,
                'message'=>'Không thể xóa vì hiện tại vẫn còn sản phẩm thuộc cơ sở này !',
            ]);
        }

        Branch::find($id)->delete();
        return response()->json([
                'error'=>false,
                'message'=>'Delete role success !',
            ]);
    }
    public function getBranches(){
        $branches = Branch::get();
        return datatables()->of($branches)->addColumn('action',function( $branches){
            $data='';
            if(Auth::user()->can('show_branch')){
                $data.='
            <button type="button" title="Xem các sản phẩm còn hạng tại cửa hàng" class="btn btn-default btn-list_detail_products" data-id="'.$branches->id.'"><i class="far fa-list-alt"></i></button>';
            }
            if (Auth::user()->can('crud_branch')) {
                $data .='
                <button title="Cập nhật thông tin chi nhánh" type="button" class="btn  btn-warning btn-edit" data-id="'.$branches->id.'"><i class="far fa-edit"></i></button>
            <button title="Xóa chi nhánh"type="button" class="btn btn-danger  btn-delete" data-id="'.$branches->id.'"><i class="far fa-trash-alt"></i></button>';
            }
            return $data;
        })
        ->editColumn('mobile',function($branches){
            return  '<a href="tel:'.$branches->mobile.'" ><i class="fas fa-phone-square"></i> &nbsp'.$branches->mobile.'</a>';
        })
        ->rawColumns(['action', 'mobile'])
        ->toJson();
    }
    public function getProductInBranch($id)
    {
         $detail_products = DB::table('branches as b')
        ->join('detail_products as dp', 'dp.branch_id', '=', 'b.id')
        ->join('colors as c', 'dp.color_id', '=', 'c.id')
        ->join('products as p', 'dp.product_id', '=', 'p.id')
        ->join('memories as m', 'm.id', '=', 'dp.memory')
        ->where('dp.branch_id', $id)
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
            ->rawColumns(['product_name', 'color_name'])
            ->toJson();
            
        
    }
}
