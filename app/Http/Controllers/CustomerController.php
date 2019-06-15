<?php

namespace App\Http\Controllers;

use App\Customer;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
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
        
        $this->middleware('permission:show_customer', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_customer', ['only' => ['store']]);
        $this->middleware('permission:update_customer', ['only' => [ 'edit', 'update']]);
        $this->middleware('permission:delete_customer', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.index');
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
    public function store(CustomerStoreRequest $request)
    {
        $path = $request->thumbnail->storeAs('customer_thumbnail',$request->thumbnail->getClientOriginalName());
       $customer = new Customer;
       $customer->name = $request->name;
       $customer->thumbnail = $path;
       $customer->mobile = $request->mobile;
       $customer->address = $request->address;
       $customer->birthday = $request->birthday;
       $customer->password = Hash::make($request->password);
       $customer->email = $request->email; 
       $customer->save();
      
        return $customer;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer=Customer::find($id);
        return $customer;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer=Customer::find($id);
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateRequest $request, $id)
    {
        $path = $request->thumbnail->storeAs('customer_thumbnail',$request->thumbnail->getClientOriginalName());
       $customer = Customer::find($id);
       $customer->name = $request->name; 
       $customer->thumbnail = $path;
       $customer->mobile = $request->mobile;
       $customer->address = $request->address;
       $customer->birthday = $request->birthday;
       $customer->password = Hash::make($request->password);
       $customer->email = $request->email; 
       $customer->save();
       $new_customer = Customer::find($id);
        return $new_customer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Customer::find($id)->delete();
    }

    public function getCustomers()
    {
        $customers = Customer::get();
        return datatables()->of($customers)->addColumn('action',function( $customers){
            $data='';
            // show customer 
             if (Auth::user()->can('show_customer')){
                 $data.= '
                <button  type="button" title="Xem thông tin khách hàng" class="btn btn-info btn-show" data-id="'.$customers->id.'"><i class="far fa-eye"></i></button>
                ';
            }
            // update
            if (Auth::user()->can('update_customer')){
                $data.='<button type="button" title="Chỉnh sửa thông tin khách hàng" class="btn  btn-warning btn-edit" data-id="'.$customers->id.'"><i class="far fa-edit"></i></button>';
            }
            // delete
            if (Auth::user()->can('delete_customer')){
                $data.='<button type="button" title="Xóa khách hàng" class="btn btn-danger  btn-delete" data-id="'.$customers->id.'"><i class="far fa-trash-alt"></i></button>';
            }
            return $data;
            
        })
        ->editColumn('thumbnail',function($customers){
            if($customers->thumbnail==null){
                return '<img style="margin:auto; width:60px; height:60px;" src ="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail">';
            }
            else{
                return '<img style="margin:auto; width:60px; height:60px;" src ="/storage/'.$customers->thumbnail.'">';
            }
        
        })
        ->editColumn('mobile',function($customers){
            return  '<a href="tel:'.$customers->mobile.'" ><i class="fas fa-phone-square"></i> &nbsp'.$customers->mobile.'</a>';
        })
        ->rawColumns(['action','thumbnail','mobile'])
        ->toJson();
    }

    public function profile($id)
    {
      $orders = DB::table('orders as o')
        ->join('statuses as st', 'st.code', '=', 'o.status')
        ->select('o.*', 'st.name as status_name')
        ->where('o.customer_id', $id)
        ->orderBy('o.id','desc')->paginate(5);


        foreach ($orders as $key => $value) {
            $value->detail_orders = DB::table('detail_orders as do')
            ->join('orders as o', 'o.id', '=', 'do.order_id')
            ->join('detail_products as dp', 'dp.id', '=', 'do.detail_product_id')
            ->join('memories as m', 'm.id', '=', 'dp.memory')
            ->join('colors as c', 'c.id', '=', 'dp.color_id')
            ->join('products as p', 'p.id', '=', 'dp.product_id')
            ->join('statuses as st', 'st.code', '=', 'o.status')
          ->select('do.*','p.name as product_name', 'p.id as product_id', 'm.name as memory', 'c.name as color_name')
            ->where('o.id', $value->id)->get();

            foreach ($value->detail_orders as $key => $detail_order) {
                 $detail_order->thumbnail =DB::table('images')
                 ->where('product_id', $detail_order->product_id)->first()->thumbnail;
            }
        }
       return view('customer.profile',['orders'=>$orders]);
    }

    public function updateProfile(CustomerUpdateRequest $request, $id)
    {
         $path = $request->thumbnail->storeAs('customer_thumbnail',$request->thumbnail->getClientOriginalName());
       $customer = Customer::find($id);
       $customer->name = $request->name; 
       $customer->thumbnail = $path;
       $customer->mobile = $request->mobile;
       $customer->address = $request->address;
       $customer->birthday = $request->birthday;
       $customer->password = Hash::make($request->password);
       $customer->email = $request->email; 
       $customer->save();
       $new_customer = Customer::find($id);
        return $new_customer;
    }
}
