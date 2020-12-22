<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShareImageReqeust extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'start_date' => 'required|date|date_format:Y-m-d',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'image' => 'required|file|max:2048|dimensions:width=720,height=1558|mimes:jpg',
                ];
            case 'PUT':
                return [
                    'start_date' => 'required|date|date_format:Y-m-d',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'image' => 'file|max:2048|width:720|dimensions:width=720,height=1558',
                ];
        }
    }

    /**
     * Custom attributes for validator errors.
     *
     * @return string[]
     */
    public function attributes() : array
    {
        return [
            'start_date' => '开始时间',
            'end_date' => '结束时间',
            'image' => '海报图片',
        ];
    }
}
