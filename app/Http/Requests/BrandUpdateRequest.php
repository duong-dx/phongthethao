<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class BrandUpdateRequest extends FormRequest
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
            'name'=>'required|min:3|max:100',
            'origin'=>'required',
            'slug'=>['required',Rule::unique('brands')->ignore($this->id)],
            'thumbnail'=>'image',
        ];
    }
    public function messages()
    {
        return [
        'name.required'=>'(*) Vui lòng nhập name',
        'name.min'=>'(*) Name tối thiệu 3 kí tự',
        'name.max'=>'(*) Name tối đa 100 kí tự',
        'origin.required'=>'(*) Vui lòng nhập nguồn gốc xuất xứ',
        'slug.required'=>'(*) Vui lòng nhập slug',
        'slug.unique'=>'(*) Slug không được phép trùng nhau',
        'thumbnail.image'=>'(*) Vui lòng chọn ảnh',
        ];
    }
}
