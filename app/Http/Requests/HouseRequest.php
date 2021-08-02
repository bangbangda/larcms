<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HouseRequest extends FormRequest
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
    public function rules(): array
    {
        return match ($this->method()) {
            'POST' => [
                'name' => 'required',
                'area' => 'required|integer',
                'weight' => 'required|integer',
                'tag' => 'required',
                'imageUrl' => 'required|array'
            ],
        };
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [
            'name' => '户型名称',
            'area' => '户型面积',
            'weight' => '排序',
            'tag' => '户型标签',
            'imageUrl' => '户型详情',
        ];
    }
}
