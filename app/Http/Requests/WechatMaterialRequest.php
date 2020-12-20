<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WechatMaterialRequest extends FormRequest
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
        $rule = [];
        switch ($this->method())
        {
            case 'POST':
                return $this->validatePost();
                break;
            default:

        }

        return $rule;
    }


    private function validatePost()
    {
        $rule = [
            'title' => 'required',
            'type' => 'required',
        ];

        switch (request()->post('type')) {
            case 'image':
                $rule['material'] = 'required|file|max:10240|mimes:bmp,png,jpeg,jpg,gif';
                break;
            case 'video':
                $rule['material'] = 'required|file|max:10240|mimes:mp4';
                break;
            case 'voice':
                $rule['material'] = 'required|file|max:2048|mimes:mp3,wma,wav,amr';
                break;
            default:
                $rule['material'] = 'required|file|max:64|mimes:jpg';
                break;
        }

        return $rule;
    }
}
