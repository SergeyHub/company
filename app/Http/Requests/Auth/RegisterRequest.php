<?php

namespace App\Http\Requests\Auth;

use App\DTO\Users\UserCreateDto;
use App\Entity\User\User;
use App\Rules\CheckRecaptcha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:16'],
            'recaptcha' => [
                'required',
                new CheckRecaptcha,
            ]
        ];
    }

    public function getDto(): UserCreateDto
    {
        return new UserCreateDto([
            'name' => 'Noname',
            'email' => $this->get('email'),
            'password' => $this->get('password'),
            'type' => $this->get('type'),
            'role' => User::ROLE_USER,
            'status' => User::STATUS_ACTIVE,
        ]);
    }
}
