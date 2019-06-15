<?php

namespace App\Http\Controllers;

use App\Status;
use Illuminate\Http\Request;
use App\Http\Requests\StatusStoreRequest;
use App\Http\Requests\StatusUpdateRequest;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('status.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StatusStoreRequest $request)
    {
        $status= Status::create($request->all());
        return $status;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status= Status::find($id);
        return $status;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(StatusUpdateRequest $request, $id)
    {
        $status= Status::find($id)->update($request->all());
        $new_status= Status::find($id);
        return $new_status;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Status::find($id)->delete();
    }
    public function getStatuses()
    {
        $statuses= Status::all();
        
        return datatables()->of($statuses)->addColumn('action', function($statuses){
          
                return '
                <button type="button" class="btn btn-warning btn-edit" title="Cập nhật thông tin" data-id="'.$statuses->id.'"><i class="far fa-edit"></i></button>
                <button title="Xóa" type="button" class="btn btn-danger  btn-delete" data-id="'.$statuses->id.'"><i class="far fa-trash-alt"></i></button>';
           
        })
       
        ->rawColumns(['action'])
        ->toJson();
    }
}
