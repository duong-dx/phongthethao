<?php

namespace App\Http\Controllers;

use App\Review;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;

class ReviewController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');

        $this->middleware('permission:show_review', ['only' => ['index', 'show']]);
        $this->middleware('permission:crud_review', ['only' => ['store', 'edit', 'update', 'destroy']]);
    }
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
    public function store(ReviewRequest $request)
    {
         $path = $request->thumbnail->storeAs('review_thumbnail',$request->thumbnail->getClientOriginalName());
       $review = new Review;
       $review->description = $request->description; 
       $review->thumbnail = $path;
       $review->product_id = $request->product_id;
       $review->content = $request->content;
       $review->save();
        return $review;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $review = Review::join('products', 'products.id', '=', 'reviews.product_id')
        ->where('reviews.id',$id)
        ->select('reviews.*', 'products.name as name')
        ->get()->first();

        return response()->json(['review'=>$review]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $review = Review::find($id);
        return $review;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(ReviewRequest $request,$id)
    {
        $path = $request->thumbnail->storeAs('review_thumbnail',$request->thumbnail->getClientOriginalName());
        $review = Review::find($id);
       $review->description = $request->description; 
       $review->thumbnail = $path;
       $review->product_id = $request->product_id;
       $review->content = $request->content;
       $review->save();
        $new_review = Review::find($id);
        return $new_review;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Review::find($id)->delete();
    }
    public function getReviews($id){
        $reviews = Review::join('products', 'products.id', '=' , 'reviews.product_id')
        ->where('reviews.product_id', $id)
        ->select('reviews.*','products.name as product_name')
        ->get();

        return datatables()->of($reviews)->addColumn('action',function( $reviews){
            $data='';
            if (Auth::user()->can('show_review')) {
                $data.= '<button  type="button" class="btn btn-info btn-show-reviews" data-id="'.$reviews->id.'"><i class="far fa-eye"></i></button>';
            }
            if(Auth::user()->can('crud_review')){
                $data.= '
            <button type="button" class="btn  btn-warning btn-edit-review" data-id="'.$reviews->id.'"><i class="far fa-edit"></i></button>
            <button type="button" class="btn btn-danger  btn-delete-review" data-id="'.$reviews->id.'"><i class="far fa-trash-alt"></i></button>';
             }
            return $data;
            
        })
        ->editColumn('product_name',function($reviews){
            return  ''.$reviews->product_name.'';
        })
         ->editColumn('thumbnail',function($reviews){

            if($reviews->thumbnail==null){
                return '<img style="margin:auto; width:100px; height:60px;" src ="/storage/default_image.png">';
            }
            else{
                return '<img style="margin:auto; width:100px; height:60px;" src ="/storage/'.$reviews->thumbnail.'">';
            }
        
        })
        ->rawColumns(['action', 'thumbnail', 'product_name'])
        ->toJson();
    }
}
