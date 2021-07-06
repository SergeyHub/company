<?php

namespace App\Http\Requests\Users;

use App\DTO\Users\UserUpdateDto;
use App\Entity\User\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        if($this->user()->isAdmin()) {
            return [
                'email' => [
                    'required',
                    Rule::unique('users', 'email')
                        ->ignore(request()->route('user')->id)
                ],
                'password' => ['nullable', 'string', 'min:6', 'max:16'],
                'type' => ['required', Rule::in(array_keys(User::typesList()))],
                'role' => ['required', Rule::in(array_keys(User::rolesList()))],
                'receive_notifications' => ['required', 'boolean']
            ];
        }

        return [
            'password' => ['nullable', 'string', 'min:6', 'max:16'],
            'receive_notifications' => ['required', 'boolean']
        ];
    }

    public function getDto(): UserUpdateDto
    {
        if($this->user()->isAdmin())
            return new UserUpdateDto([
                'email' => $this->get('email'),
                'password' => $this->get('password'),
                'type' => $this->get('type'),
                'role' => $this->get('role'),
                'receive_notifications' => !!$this->get('receive_notifications'),
            ]);

        return new UserUpdateDto([
            'password' => $this->get('password'),
            'receive_notifications' => !!$this->get('receive_notifications'),
        ]);
    }
}
