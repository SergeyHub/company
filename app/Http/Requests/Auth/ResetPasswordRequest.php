<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\Users\ResetPasswordDto;

class ResetPasswordRequest extends FormRequest
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
            'resetToken' => 'required',
            'password' => 'required|min:8'
        ];
    }

    public function getDto(): ResetPasswordDto {
        return new ResetPasswordDto([
            'name' => $this->get('resetToken'),
            'password' => $this->get('password')
        ]);
    }

}
