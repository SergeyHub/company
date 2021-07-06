<?php

namespace App\Http\Requests\Agencies;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadAvatarRequest extends FormRequest
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
            'file' => [
                'required',
                'image',
                'max:20480', // 20 MB max
                Rule::dimensions()
                    ->maxHeight(20000)
                    ->maxWidth(10000)
            ]
        ];
    }
}
