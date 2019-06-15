<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\RoleUser;
use App\Permission;
use App\PermissionRole;
use App\Http\Requests\RoleStoreRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Requests\PermissionRoleRequest;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::get();
        return view('role.index',['permissions'=>$permissions]);
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
    public function store(RoleStoreRequest $request)
    {
        $role= Role::create($request->all());
        return $role;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $role= Role::find($id);

        return $role;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleUpdateRequest $request, $id)
    {
         $role= Role::find($id)->update($request->all());
          $new_role= Role::find($id);
        return $new_role;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = RoleUser::where('role_id', $id)->first();
        if($exists!=null){
            return response()->json([
                'error'=>true,
                'message'=>'Không thể xóa vì có giàng buộc !',
            ]);
        }

        PermissionRole::where('role_id',$id)->delete();
        Role::find($id)->delete();
       
        return response()->json([
                'error'=>false,
                'message'=>'Delete role success !',
            ]);
    }

    public function getRoles()
    {
        $roles = Role::get();
        return datatables()->of($roles)->addColumn('action',function($roles){
                return'
             <button type="button" title="Chỉnh sửa thông tin" class="btn  btn-info btn-permission" data-id="'.$roles->id.'"><i class="fas fa-tools"></i></button>
            <button type="button" title="Chỉnh sửa thông tin" class="btn  btn-warning btn-edit" data-id="'.$roles->id.'"><i class="far fa-edit"></i></button>
            <button type="button"  title="Xóa sản phẩm" class="btn btn-danger  btn-delete" data-id="'.$roles->id.'"><i class="far fa-trash-alt"></i></button>';
            })
        ->rawColumns(['action'])
        ->toJson();

    }
    public function getPermissionRole($id)
    {
        $permission_role = PermissionRole::where('role_id',$id)->get();
        return $permission_role;
    }
    public function addPermissionRol(PermissionRoleRequest $request)
    {
         PermissionRole::where('role_id',$request->role_id)->delete();
        for ($i=0; $i < $request->dem ; $i++) { 
            $permission_role = new PermissionRole;
            $permission_role->role_id =$request->role_id;
            $permission_role->permission_id =$request->$i;
            $permission_role->save();
        }

        $permission_roles = PermissionRole::where('role_id',$request->role_id)->get();
        return $permission_roles;
    }
}
