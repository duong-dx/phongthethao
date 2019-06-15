<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductImageRequest extends FormRequest
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
            'file'=>'required|image',
            'product_id'=>'required|exists:products,id',
        ];
        return [
            'file.required'=>'Vui lòng chọn ảnh !',
            'file.image'=>'Ảnh sản phẩm phải là ảnh !',
            'product_id.required'=>'Vui lòng nhập mã sản phẩm !',
            'product_id.exists'=>'Sản phẩm không tồn tại !',
        ];
    }
    }
}
