<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
                'title' => 'required|max:80',
                'image' => 'required|image|max:1024',
                'original_url' => 'required|url',
            ],
            'PUT' => [
                'title' => 'required|max:80',
                'image' => 'required_without:cover_url|image|max:1024',
                'original_url' => 'required|url',
            ],
        };
    }

    public function attributes()
    {
        return [
            'title' => '新闻标题',
            'original_url' => '跳转地址',
            'image' => '封面图片',
            'cover_url' => '封面图片地址'
        ];
    }
}
