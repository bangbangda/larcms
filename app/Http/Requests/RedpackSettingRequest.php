<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RedpackSettingRequest extends FormRequest
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
            'type' => 'required',
            'amount' => 'required|numeric',
            'start_date' => 'date',
            'end_date' => 'date|before:start_date',
            'step_amount' => 'required|numeric',
        ];

        return $rule;
    }
}
