<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleUserRequest extends FormRequest
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
            'user_id'=>['required', 'numeric', 'exists:users,id'],
            'role_id'=>['required', 'numeric', 'exists:roles,id'],
        ];
    }
    public function messages()
    {
        return [
            'user_id.required'=>'user_id không được bỏ trống !',
            'user_id.numeric'=>'user_id phải là sô !',
            'user_id.exists'=>'Người dùng không tồn tại',
            'role_id.required'=>'Vui lòng chọn vai trò !',
            'role_id.numeric'=>'role_id phải là sô !',
            'role_id.exists'=>'Vai trò không tồn tại',
        ];
    }
}
