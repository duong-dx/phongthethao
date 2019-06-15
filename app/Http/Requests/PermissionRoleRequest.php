<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRoleRequest extends FormRequest
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
            'role_id'=>['required', 'numeric', 'exists:roles,id'],
        ];
    }
    public function messages()
    {
        return [
            'role_id.required'=>'role_id không được bỏ trống !',
            'role_id.numeric'=>'role_id phải là số !',
            'role_id.exists'=>'Vai trò không tồn tại !',
        ];
    }
}
