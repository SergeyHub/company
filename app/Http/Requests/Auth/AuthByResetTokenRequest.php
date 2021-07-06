<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthByResetTokenRequest extends FormRequest
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
            'email' => 'required|email|exists:users'
        ];
    }

    public function messages() {
        return [
            'resetToken.required' => 'Token not found or expired',
            'email.exists' => 'Use with given email not found'
        ];
    }

}
