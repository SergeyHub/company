<?php

namespace App\Http\Requests\Girls;

use Illuminate\Foundation\Http\FormRequest;

class UploadHiddenPhotoRequest extends FormRequest
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
            'image' => 'required|base64image'
        ];
    }
}
