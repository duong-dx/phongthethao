<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            'product_id'=>['required', 'integer', 'exists:products,id'],
            'quantity_buy'=>['required', 'numeric', 'min:0','not_in:0']
        ];
    }
    public function messages()
    {
        return [
            'product_id.required'=>'Vui lòng nhập id product !',
            'product_id.integer'=>'detail_product_id phải là số nguyên !',
            'product_id.exists'=>'Bản ghi không tồn tại !',
            'quantity_buy.required'=>'Vui lòng nhập số lượng mua !',
            'quantity_buy.min'=>'Số lượng phải lớn hơn 0 !',
            'quantity_buy.numeric'=>'Số lượng mua phải là số !',
            'quantity_buy.not_in'=>'Số lượng mua phải lớn hơn 0 !',

        ];
        
    }
}
