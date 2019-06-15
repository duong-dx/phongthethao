<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionUpdateRequest extends FormRequest
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
            'name'=>['required', Rule::unique('permissions')->ignore($this->id)],
            'display_name'=>'required|max:255',
            'description'=>'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'(*) Tên không đươc bỏ trống !',
            'name.unique'=>'(*) Tên đã tồn tại . Vui lòng nhập tên khác !',
            'display_name.required'=>'(*) Tên hiển thị không đươc bỏ trống !',
            'display_name.max'=>'(*) Tên hiển thị tối đa là 255 ký tự !',
            'description.required'=>'(*) Đoạn mô tả không đươc bỏ trống !',
            'description.max'=>'(*) Tên hiển thị tối đa là 255 ký tự !',
        ];
    }
}
