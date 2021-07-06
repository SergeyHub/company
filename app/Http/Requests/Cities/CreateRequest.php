<?php

namespace App\Http\Requests\Cities;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
        $rules = [
            'country_id' => 'required|exists:countries,id',
            'slug' => 'required|unique:cities',
            'status' => 'nullable|numeric|min:0|max:1'
        ];

        $locales = config('translatable.locales');
        foreach ($locales as $locale) {
            $rules[$locale . '.name'] = 'required';
        }

        return $rules;
    }
}
