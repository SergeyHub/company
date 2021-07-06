<?php

namespace App\Http\Requests\Girls;

use App\Entity\Girl\Girl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RemoveVideoRequest extends FormRequest
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
            'id' => [
                'required',
                Rule::exists('media', 'id')
                    ->where('model_type', Girl::class)
                    ->where('model_id', $this->route('id'))
            ]
        ];
    }
}
