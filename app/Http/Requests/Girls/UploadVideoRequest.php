<?php

namespace App\Http\Requests\Girls;

use Illuminate\Foundation\Http\FormRequest;

class UploadVideoRequest extends FormRequest
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
                'mimes:mp4,ogx,oga,ogv,ogg,webm,avi',
                'max:102400', // 100 MB max
            ]
        ];
    }
}
