<?php

namespace App\Http\Requests\Girls;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Girls\GirlRejectVerificationDto;

class UnverifyRequest extends FormRequest
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
            'reason' => 'required'
        ];
    }

    public function getDto() {
        return new GirlRejectVerificationDto([
            'reason' => $this->get('reason')
        ]);
    }
}
