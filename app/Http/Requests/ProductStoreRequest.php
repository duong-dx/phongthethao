<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ProductStoreRequest extends FormRequest
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
            'slug'=>'required|unique:products,slug',
            'brand_id' => ['required', 'numeric', 'exists:brands,id'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
            'price'=>'required|numeric|not_in:0|min:0',
            'quantity'=>'required|numeric|not_in:0|min:0',
            'sale'=>'required|max:10|numeric|not_in:0|min:0',
            'branch_id'=>['required', 'numeric', 'exists:branches,id'],
            'description'=>'required|max:255|string',
            'content'=>'required|string',
            
        ];
    }
    public function messages()
    {
        return [
        'name.required'=>'(*) Vui lòng nhập name !',
        'name.min'=>'(*) Name tối thiệu 5 kí tự !',
        'name.max'=>'(*) Name tối đa 100 kí tự !',
        'slug.required'=> '(*) Vui lòng nhập vào slug !',
        'slug.unique'=> '(*) Slug đã được sử dụng !',
        'code.required'=> '(*) Vui lòng nhập vào code !',
        'brand_id.required'=> '(*) Vui lòng chọn thương hiệu !',
        'brand_id.numeric'=> '(*) Id thương hiệu phải là số !',
        'brand_id.exists'=> '(*) Thương hiệu không tồn tại !',
        'category_id.required'=> '(*) Vui lòng chọn loại sản phẩm !',
        'category_id.numeric'=> '(*) Id loại sản phẩm phải là số !',
        'category_id.exists'=> '(*) Loại sản phẩm không tồn tại !',
        'warranty_time.required'=>'(*) Vui lòng nhập thời gian bảo hành !',
        'ram.required'=>'(*) Vui lòng nhập Ram của máy !',
        'weight.required'=>'(*) Vui lòng nhập cân nặng của máy !',
        'screen_size.required'=>'(*) Vui lòng nhập kích thước màn hình !',
        'pin.required'=>'(*) Vui lòng nhập dung lượng pin !',
        'front_camera.required'=>'(*) Vui lòng nhập độ phân giải camera trước !',
        'rear_camera.required'=>'(*) Vui lòng nhập độ phân giải camera sau !',
        'operating_system.required'=>'(*) Vui lòng nhập hệ điều hành !',
        'branch_id.required'=>'(*) Vui lòng chọn chi nhánh !',
        'branch_id.numeric'=>'(*)  Branch_id phải là số !',
        'branch_id.exists'=>'(*)  Chi nhánh không tồn tại !',
        'price.required'=>'(*) Vui lòng nhập vào giá sản phẩm !',
        'price.numeric'=>'(*) Giá sản phẩm phải là số !',
        'price.not_in'=>'(*) Giá sản phẩm phải lớn hơn 0 !',
        'price.min'=>'(*) Giá sản phẩm phải lớn hơn 0 !',
        'quantity.required'=>'(*) Vui lòng nhập vào số lượng !',
        'quantity.numeric'=>'(*) Số lượng phải là số !',
        'quantity.not_in'=>'(*) Số lượng phải lớn hơn 0 !',
        'quantity.min'=>'(*) Số lượng phải lớn hơn 0 !',
        'sale.required'=>'(*) Vui lòng nhập vào phầm trăm giảm giá !',
        'sale.numeric'=>'(*) Phầm trăm giảm giá phải là số !',
        'sale.not_in'=>'(*) Phầm trăm giảm giá phải lớn hơn 0 !',
        'sale.min'=>'(*) Phầm trăm giảm giá phải lớn hơn 0 !',
        'sale.max'=>'(*) Phầm trăm giảm giá phải nhỏ hơn 10 % !',
        'description.required'=> 'Vui lòng nhập vào miêu tả !',
        'description.string'=> 'Đoạn mô tả phải là 1 chuỗi !',
        'description.max'=>'Đoạn miêu tả tối đa 255 kí tự !',
        'content.required'=>'Vui lòng nhập vào nội dung !',
        'content.string'=>'Nội dung phải là một chuỗi !',
        ];
    }
}
