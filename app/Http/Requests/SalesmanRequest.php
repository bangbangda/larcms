<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesmanRequest extends FormRequest
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
        switch ($this->route()->getName()) {
            case 'salesman.store':
                return [
                    'name' => 'required|string|max:10',
                    'image' => 'required|file|max:2048|mimes:jpg,png,jpeg',
                    'position' => 'required|string|max:15',
                    'phone' => 'required|phone:CN,mobile',
                    'wechat' => 'required|string',
                ];
            case 'salesman.update':
                return [
                    'name' => 'required|string|max:10',
                    'position' => 'required|string|max:15',
                    'phone' => 'required|phone:CN,mobile',
                    'wechat' => 'required|string',
                ];
            default:
                return [
                    //
                ];
        }
    }


    public function attributes()
    {
        return [
            'name' => '顾问名称',
            'image' => '顾问头像',
            'position' => '顾问呢职位',
            'phone' => '手机号',
            'wechat' => '微信号',
        ];
    }
}
