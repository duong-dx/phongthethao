<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatusStoreRequest extends FormRequest
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
            'code'=>'required|numeric|unique:statuses,code',
            'name'=>'required|min:5|max:100',
        ];
    }
    public function messages()
    {
        return [
            'code.required'=>'Vui lòng nhập vào code !',
            'code.numeric'=>'Code phải là số !',
            'code.unique'=>'Code đã được sử dụng vui lòng chọn code khác !',
            'name.required'=>'(*) Vui lòng nhập name !',
            'name.min'=>'(*) Name tối thiệu 5 kí tự !',
            'name.max'=>'(*) Name tối đa 100 kí tự !',
        ];
    }
}
