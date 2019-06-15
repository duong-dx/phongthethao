<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DetailProductStoreRequest extends FormRequest
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
            'product_id'=>['required', 'numeric', 'exists:products,id'],
            'color_id'=>['required', 'numeric', 'exists:colors,id'],
            'price'=>'required|numeric',
            'sale_price'=>'required|numeric',
            'quantity'=>'required|numeric|not_in:0|min:0',
            'branch_id'=>['required', 'numeric', 'exists:branches,id'],
            'memory'=>['required', 'numeric', 'exists:memories,id'],
            'category_id'=>['required', 'numeric', 'exists:categories,id']
        ];
    }
    public function messages()
    {
        return [
        'product_id.required'=>'(*) Vui lòng nhập không sửa product_id !',
        'product_id.numeric'=>'(*) Product_id phải là số !',
        'product_id.exists'=>'(*) Sản phẩm không tồn tại !',
        'color_id.required'=>'(*) Vui lòng chọn màu sắc !',
        'color_id.numeric'=>'(*)  Color_id phải là số !',
        'color_id.exists'=>'(*) Màu sắc không tồn tại !',
        'branch_id.required'=>'(*) Vui lòng chọn Chi nhánh !',
        'branch_id.numeric'=>'(*)  Branch_id phải là số !',
        'branch_id.exists'=>'(*)  Chi nhánh không tồn tại !',
        'price.required'=>'(*) Vui lòng nhập vào giá sản phẩm !',
        'price.numeric'=>'(*) Giá sản phẩm phải là số !',
        'sale_price.required'=>'(*) Vui lòng nhập vào giá bán sản phẩm !',
        'sale_price.numeric'=>'(*) Giá bán sản phẩm phải là số !',
        'quantity.required'=>'(*) Vui lòng nhập vào số lượng !',
        'quantity.numeric'=>'(*) Số lượng phải là số !',
        'quantity.not_in'=>'(*) Số lượng phải lớn hơn 0 !',
        'quantity.min'=>'(*) Số lượng phải lớn hơn 0 !',
        'memory.required'=>'(*) Vui lòng chọn vào Dung Lượng !',
        'memory.numeric'=>'(*) Dung Lượng phải là phải số !',
        'memory.exists'=>'(*) Dung Lượng không tồn tại !',
        ];
    }
}
