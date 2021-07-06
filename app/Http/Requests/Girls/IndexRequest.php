<?php

namespace App\Http\Requests\Girls;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'country' => 'nullable|exists:countries,id',
            'city' => 'nullable|exists:cities,id',
            'geography' => 'nullable|exists:geographies,id',
            'random' => 'nullable|bool',
            'age_from' => 'nullable|numeric',
            'age_to' => 'nullable|numeric',
            'height_from' => 'nullable|numeric',
            'height_to' => 'nullable|numeric',
            'ready_for_travels' => 'nullable',
            'nationality' => 'nullable|exists:nationalities,id',
            'hairs' => 'nullable|exists:hairs,id',
            'verified' => 'nullable',
            'query' => 'nullable|string',
            'vip' => 'nullable|boolean'
        ];
    }
}
