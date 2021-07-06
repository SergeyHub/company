<?php

namespace App\Http\Requests\Countries;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'slug' => 'required|unique:cities,slug,except,'.request()->route('id'),
            'status' => 'nullable|numeric|min:0|max:1'
        ];

        $locales = config('translatable.locales');
        foreach ($locales as $locale) {
            $rules[$locale . '.name'] = 'required';
        }

        return $rules;
    }
}
