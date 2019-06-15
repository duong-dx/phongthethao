<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\RoleUser;
use App\Product;
use Auth;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\RoleUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
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

        $this->middleware('permission:show_user', ['only' => ['index', 'show']]);
        $this->middleware('permission:add_user', ['only' => ['store']]);
        $this->middleware('permission:update_user', ['only' => [ 'edit', 'update']]);
        $this->middleware('permission:delete_user', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();
        return view('user.index',['roles'=>$roles]);
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
    public function store(UserStoreRequest $request)
    {
        $path = $request->thumbnail->storeAs('user_thumbnail',$request->thumbnail->getClientOriginalName());
       $user = new User;
       $user->name = $request->name; 
       $user->thumbnail = $path;
       $user->mobile = $request->mobile;
       $user->address = $request->address;
       $user->birthday = $request->birthday;
       $user->password = Hash::make($request->password);
       $user->email = $request->email; 
       $user->save();
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update( UserUpdateRequest $request, $id)
    {
       $path = $request->thumbnail->storeAs('user_thumbnail',$request->thumbnail->getClientOriginalName());
       $user = User::find($id);
       $user->name = $request->name; 
       $user->thumbnail = $path;
       $user->mobile = $request->mobile;
       $user->address = $request->address;
       $user->birthday = $request->birthday;
       $user->password = Hash::make($request->password);
       $user->email = $request->email; 
       $user->save();
       $new_user = User::find($id);
        return $new_user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $exists = Product::where('user_id', $id)->first();
        if($exists!=null){
            return response()->json([
                'error'=>true,
                'message'=>'Không thể xóa vì hiện tại có sản phẩm được thêm bởi nhân viên này !',
            ]);
        }
        RoleUser::where('user_id',$id)->delete();
        User::find($id)->delete();
        return response()->json([
                'error'=>false,
                'message'=>'Delete role success !',
            ]);
    }

    public function getUsers(){
        $users = User::get();
        return datatables()->of($users)->addColumn('action',function( $users){
            $data='';
            // chỉnh sửa quyền hạn
            if(Auth::user()->can('edit_role_user')){
                $data.='<button  type="button" title="Chỉnh sửa quyền hạn" class="btn btn-success btn-role" data-id="'.$users->id.'"><i class="fas fa-users-cog"></i></button>';
            }
            // show chi tiêt
            if(Auth::user()->can('show_user')){
                $data .= '
                <button  type="button" title="Xem thông tin nhân viên" class="btn btn-info btn-show" data-id="'.$users->id.'"><i class="far fa-eye"></i></button>
            ';
            }
            //được update 
            if(Auth::user()->can('update_user')){
                $data.='<button type="button" title="Chỉnh sửa thông tin nhân viên" class="btn  btn-warning btn-edit" data-id="'.$users->id.'"><i class="far fa-edit"></i></button>';
            }
            // xóa nhân viên
            if (Auth::user()->can('delete_user')) {
                $data.='<button type="button" title="Xóa nhân viên" class="btn btn-danger  btn-delete" data-id="'.$users->id.'"><i class="far fa-trash-alt"></i></button>';
            }
            
            return $data;
            
        })
        ->editColumn('thumbnail',function($users){
        return '<img style="margin:auto; width:60px; height:60px;" src ="/storage/'.$users->thumbnail.'">';
        })
        ->editColumn('mobile',function($users){
            return  '<a href="tel:'.$users->mobile.'" ><i class="fas fa-phone-square"></i> &nbsp'.$users->mobile.'</a>';
        })
        ->rawColumns(['action','thumbnail','mobile'])
        ->toJson();
    }
    public function getRoleUser($id){
        $role_user = RoleUser::where('user_id',$id)->get()->first();
        
        return $role_user;
    }
    public function addRoleUser(RoleUserRequest $request)
    {
        RoleUser::where('user_id',$request->user_id)->delete();

        $role_user = new RoleUser;
        $role_user->user_id= $request->user_id;
        $role_user->role_id= $request->role_id;
        $role_user->save();
        return $role_user;
    }
}
