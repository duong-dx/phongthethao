<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\PermissionRole;
use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;

class PermissionController extends Controller
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
        
        return view('permission.index');
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
    public function store(PermissionStoreRequest $request)
    {
       $permission = Permission::create($request->all());
       return $permission;
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
        $permission = Permission::find($id);
        return $permission;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        $permission = Permission::find($id)->update($request->all());
        $new_permission = Permission::find($id);
        return $new_permission;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $exists = PermissionRole::where('permission_id', $id)->first();
        if($exists!=null){
            return response()->json([
                'error'=>true,
                'message'=>'Không thể xóa vì có giàng buộc !',
            ]);
        }

        Permission::find($id)->delete();
        return response()->json([
                'error'=>false,
                'message'=>'Delete role success !',
            ]);
    }

    public function getPermissions()
    {
        $permissions = Permission::get();
        return datatables()->of($permissions)->addColumn('action',function($permissions){
                return'
                
            <button type="button" title="Chỉnh sửa thông tin" class="btn  btn-warning btn-edit" data-id="'.$permissions->id.'"><i class="far fa-edit"></i></button>
            <button type="button"  title="Xóa sản phẩm" class="btn btn-danger  btn-delete" data-id="'.$permissions->id.'"><i class="far fa-trash-alt"></i></button>';
            })
        ->rawColumns(['action'])
        ->toJson();

    }
    // show các permission theo datatable
    public function showPermissions($id)
    {

    //      $permissions = Permission::orderBy('id', 'desc')->get();

    //      foreach ($permissions as $key => $permission) {
    //          $permission->checked = !empty(PermissionRole::where('role_id', $id)->where('permission_id', $permission->id)->first());
    //      }

    //     return datatables()->of($permissions)

    //         ->addColumn('action',function($permission) {
             
    //             if ($permission->checked) 
    //                 return'
    //                     <label class="custom-control custom-checkbox">
    //                                 <input style="display:none;" id="permission'.$permission->id.'" type="checkbox" name="permission_id"
    //                                 value="'.$permission->id.'" class="custom-control-input permissions" checked="'. $permission->checked .'">
    //                                 <span class="custom-control-indicator"></span>
    //                             </label>';
    //             else
    //                 return'
    //                     <label class="custom-control custom-checkbox">
    //                                 <input style="display:none;" id="permission'.$permission->id.'" type="checkbox" name="permission_id"
    //                                 value="'.$permission->id.'" class="custom-control-input permissions">
    //                                 <span class="custom-control-indicator"></span>
    //                             </label>';

    //         })
    //     ->rawColumns(['action'])
    //     ->toJson();
    }
}
