<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetRequest extends FormRequest
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
            'email'=>['required', 'email', 'exists:customers,email'],
        ];
    }
    public function messages()
    {
        return [
            'email.required'=>'Vui lòng nhập email !',
            'email.email'=>'Vui lòng nhập đúng định dạng email !',
            'email.exists'=>'email của bạn không tồn tại !',
        ];
    }
}
