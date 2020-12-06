<?php

namespace App\Http\Requests\API;


use Faker\Provider\Payment;

class CustomerRequest extends FormRequest
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
        switch (request()->route()->getName()) {
            case 'miniApp.login' :
            case 'miniApp.hasSubscribeMpByCode' :
                return [
                    'code' => 'required|string'
                ];
            case 'miniApp.decryptPhone' :
                return [
                    'iv' => 'required|string',
                    'encryptedData' => 'required|string',
                ];
            default :
                return [];

        }
    }

    public function attributes()
    {
        return [
            'code' => '小程序用户登录凭证',
            'iv' => '加密算法[iv]',
            'encryptedData' => '加密数据[encryptedData]'
        ];
    }
}
