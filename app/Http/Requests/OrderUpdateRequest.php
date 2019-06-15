<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'status'=>'required|numeric|exists:statuses,code',
        ];
    }
    public function messages()
    {
        return [
            'status.required'=>'Vui lòng chọn trạng thái !',
            'status.numeric'=>'status_id phải là số !',
            'status.exists'=>'status_id khồn tồn tại !',
        ];
        
    }
}
