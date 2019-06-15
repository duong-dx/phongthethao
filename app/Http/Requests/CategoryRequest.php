<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|min:5|max:100',
            'description'=>'required',
            'slug'=>'required|unique:categories,slug',
            'parent_id'=>'required|numeric',
            'thumbnail'=>'required',
        ];
    }
    public function messages()
    {
        return [
        'name.required'=>'(*) Vui lòng nhập name',
        'name.min'=>'(*) Name tối thiệu 5 kí tự',
        'name.max'=>'(*) Name tối đa 100 kí tự',
        'description.required'=>'(*) Vui lòng nhập description',
        'slug.required'=>'(*) Vui lòng nhập slug',
        'slug.unique'=>'(*) Slug không được phép trùng nhau',
        'parent_id.required'=>'(*) Vui lòng nhập parent_id',
        'parent_id.numeric'=>'(*) Parent id phải là số',
        'thumbnail.required'=>'(*) Vui lòng nhập thumbnail',
        
        
        ];
    }
}
