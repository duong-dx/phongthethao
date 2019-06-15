<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UserUpdateRequest extends FormRequest
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
            'mobile'=>'required|numeric',
            'password'=>'required|min:6|max:50',
            'address'=>'required',
            'birthday'=>'date',
            'email'=>['required', 'email', Rule::unique('users')->ignore($this->id)],
            'thumbnail'=>'required|image',
        ];
    }
    public function messages()
    {
        return [
        'name.required'=>'(*) Vui lòng nhập name !',
        'name.min'=>'(*) Name tối thiệu 5 kí tự !',
        'name.max'=>'(*) Name tối đa 100 kí tự !',
        'mobile.required'=>'(*) Vui lòng nhập số điện thoại !',
        'mobile.numeric'=>'(*) Số điện thoại phải là số !',
        'password.required'=>'(*) Vui lòng nhập mật khẩu !',
        'password.min'=>'(*) Mật khẩu tối thiểu là 6 kí tự !',
        'password.max'=>'(*) Mật khẩu tối đa là 50 kí tự !',
        'address.required'=>'(*) Vui lòng nhập địa chỉ nhân viên !',
        'birthday.date'=>'(*) Yêu cầu nhập đúng định dạng date !',
        'email.required'=>'(*) Vui lòng nhập Email !',
        'email.email'=>'(*) Yêu cầu nhập đúng định dạng Email !',
        'email.unique'=>'(*) Email đã được sử dụng !',
        'thumbnail.required'=>'(*) Vui lòng chọn ảnh đại diện !',
        'thumbnail.image'=>'(*) Ảnh đại diện phải là một ảnh !',
        ];
    }
}
