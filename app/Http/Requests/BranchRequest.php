<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
           'name'=>'required|min:10|max:100',
            'mobile'=>'required|numeric',
            'address'=>'required',
            
        ];
    }
    public function messages()
    {
        return [
        'name.required'=>'(*) Vui lòng nhập name !',
        'name.min'=>'(*) Name tối thiệu 10 kí tự !',
        'name.max'=>'(*) Name tối đa 100 kí tự !',
        'mobile.required'=>'(*) Vui lòng nhập số điện thoại !',
        'mobile.numeric'=>'(*) Số điện thoại phải là số !',
        'address.required'=>'(*) Địa chỉ không được để trống !',
        
        ];
    }
}
