<?php

namespace App\Http\Requests\API;


class HomeRequest extends FormRequest
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
        if (request()->route()->getName() == 'miniApp.home.randomCodeRedpack') {
            return [
                'randomCode' => 'required|string|size:13'
            ];
        }
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'randomCode' => '红包随机码',
        ];
    }
}
