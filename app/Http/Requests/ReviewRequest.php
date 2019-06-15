<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'thumbnail'=>'required|image',
            'description'=>'required|min:10|max:200',
            'content'=>'required|min:10|max:255',
            'product_id'=>['required', 'numeric', 'exists:products,id'],
        ];
    }
    public function messages()
    {
        return [
            
            'description.required'=>'Vui lòng nhập đoạn miêu tả !',
            'description.min'=>'Đoạn miêu tả tối thiểu là 10 kí tự !',
            'description.max'=>'Đoạn miêu tả tối đa là 200 ký tự !',
            'content.required'=> 'Vui lòng nhập nội dung !',
            'content.min'=>'Nội dung tối thiểu là 10 ký tự !',
            'content.max'=>'Nội dung tối đa là 255 ký tự !',
            'product_id.required'=>'Vui lòng nhập product_id !',
            'product_id.numeric'=>'Product id phải là số !',
            'product_id.exists'=>'Sản phẩm không tồn tại !',
            'thumbnail.image'=>'Vui lòng chọn ảnh !',

        ];
    }
}
