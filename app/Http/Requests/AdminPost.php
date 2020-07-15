<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/*
 * 继承表单请求类
 */
class AdminPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 权限 --!
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
            'yx_username'=>'required',
            'yx_password'=>'required'
        ];
    }
}
