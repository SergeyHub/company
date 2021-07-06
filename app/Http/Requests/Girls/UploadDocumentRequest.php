<?php

namespace App\Http\Requests\Girls;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadDocumentRequest extends FormRequest
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
                'max:10240', // 10 MB max
                Rule::dimensions()
                    ->maxHeight(4000)
                    ->maxWidth(6000)
            ]
        ];
    }
}
