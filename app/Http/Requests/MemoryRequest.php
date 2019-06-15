<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemoryRequest extends FormRequest
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
            'name'=>'required|max:100',
            'code'=>'required',
        ];
    }
    public function messages()
    {
        return[
            'name.required'=>'(*) Vui lòng nhập tên dung lượng !',
            'name.max'=>'(*) Name tối đa 100 kí tự',
            'code.required'=>('(*) Vui lòng nhập  dung lượng bộ nhớ !')
            ];
    }
}
