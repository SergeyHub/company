<?php

namespace App\Http\Requests\Messages;

use App\DTO\Messages\MessageDto;
use App\Entity\User\User;
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
        return [
            'user_to' => 'required|exists:users,id',
            'content' => 'required|min:1|max:300'
        ];
    }

    public function getDto(): MessageDto
    {
        return new MessageDto([
            'user_from' => $this->user(),
            'user_to' => User::find($this->get('user_to')),
            'content' => $this->get('content'),
        ]);
    }
}
