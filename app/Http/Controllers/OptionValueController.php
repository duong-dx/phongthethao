<?php

namespace App\Http\Controllers;

use App\OptionValue;
use App\Option;
use Illuminate\Http\Request;

class OptionValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OptionValue  $optionValue
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $option_values = OptionValue::join('options','option_values.option_id','=','options.id')
            ->where('option_values.option_id',$id)->get();
            // if( $option_values!=null){
                return datatables()->of($option_values)->editColumn('code',function($option_values){
                return ''.$option_values->code.'';
                })
               ->editColumn('option_name',function($option_values){
                return ''.$option_values->name.'';
                })
                ->rawColumns(['code','option_name'])
                 ->toJson();
            // }
            // else{
            //     return response()->json(['null',$null]);
            // }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OptionValue  $optionValue
     * @return \Illuminate\Http\Response
     */
    public function edit(OptionValue $optionValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OptionValue  $optionValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OptionValue $optionValue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OptionValue  $optionValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(OptionValue $optionValue)
    {
        //
    }
    public function getOptionValues($id){
       //  $option_values = OptionValue::join('options','option_values.option_id','=','options.id')
       //      ->where('option_values.option_id',$id)->get();
       //   return datatables()->of($option_values)->editColumn('code',function($option_values){
       //  return '<div style="width:30px; height:30px; background:'.$option_values->code.';"></div>';
       //  })
       // ->editColumn('option_name',function($option_values){
       //  return ''.$option_values->name.'';
       //  })
       //  ->rawColumns(['code','option_name'])
       //   ->toJson();
    }
}
