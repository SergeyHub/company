<?php

namespace App\Http\Requests\Girls;

use App\Entity\Girl\Girl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreByGirlRequest extends FormRequest
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
            'type' => [
                'required',
                Rule::in(Girl::GIRL_TYPES),
                Rule::unique('girls', 'type')->where(function ($query) {
                    return $query->where('user_id', $this->user()->id)->whereNull('deleted_at');
                }),
            ]
        ];
    }

    public function messages() {
        return [
            'type.unique' => __('validation.alone_girl_type')
        ];
    }
}
