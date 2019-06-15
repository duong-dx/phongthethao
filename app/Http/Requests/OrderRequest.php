<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'customer_name'=>'required|min:5|max:255',
            'customer_address'=>'required|min:5|max:255',
            'customer_mobile'=>'required|numeric',
        ];
    }
    public function messages()
    {
        return [
            'customer_name.required'=>'Vui lòng nhập tên của khách hàng !',
            'customer_name.min'=>'Vui lòng nhập đầy đủ họ tên khách hàng !',
            'customer_name.max'=>'Tên quá dài !',
            'customer_address.required'=>'Vui lòng nhập địa chỉ của khách hàng !',
            'customer_address.min'=>'Vui lòng nhập đầy đủ số nhà và địa chỉ khách hàng !',
            'customer_address.max'=>'Địa chỉ quá dài !',
            'customer_mobile.required'=>'Vui lòng nhập số điện thoại của khách hàng !',
            'customer_mobile.numeric'=>'Số điện thoại phải là định dạng số !',

        ];
    }
}
