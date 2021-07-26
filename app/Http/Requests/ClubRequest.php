<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClubRequest extends FormRequest
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
            case 'club.store':
                return [
                    'name' => 'required|string|max:16',
                    'image' => 'required|file|max:2048|mimes:jpg,png,jpeg',
                    'weight' => 'required|integer|max:100',
                ];
            default:
                return [];
        }
    }

    public function attributes()
    {
        return [
            'name' => '房间名称',
            'image' => '房间图片',
            'weight' => '房间排序',
        ];
    }
}
