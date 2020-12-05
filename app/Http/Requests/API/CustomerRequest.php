<?php

namespace App\Http\Requests\API;


class CustomerRequest extends FromRequest
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
            'code' => 'required|string'
        ];
    }

    public function attributes()
    {
        return [
            'code' => '小程序用户登录凭证'
        ];
    }
}
