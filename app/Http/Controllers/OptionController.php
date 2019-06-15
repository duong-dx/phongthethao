<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Option;
use App\Http\Requests\OptionRequest;

class OptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('option.index');
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
    public function store(OptionRequest $request)
    {
        $option = Option::create($request->all());
        return $option;
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
        $option = Option::find($id);
        return $option;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OptionRequest $request, $id)
    {
        $option = Option::find($id)->update($request->all());
        $new_option= Option::find($id);
        return $new_option;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Option::find($id)->delete();
    }
    public function getOptions()
    {
        $options = Option::get();

        return datatables()->of($options)->addColumn('action',function($options){
            return '<button type="button" title="Xem chi tiết" class="btn btn-info btn-show" data-id="'.$options->id.'"><i class="far fa-eye"></i></button>
        <button type="button" class="btn  btn-warning btn-edit" data-id="'.$options->id.'"><i class="far fa-edit"></i></button>
        <button type="button" class="btn btn-danger  btn-delete" data-id="'.$options->id.'"><i class="far fa-trash-alt"></i></button>';
        })
       
        ->rawColumns(['action'])
         ->toJson();
    }
}
