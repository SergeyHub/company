<?php

namespace App\Http\Requests\Support;

use App\DTO\Support\SupportMessageDto;
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
        $rules = [
            'content' => 'required|max:512',
        ];
        // админ может отправлять сообщения юзерам
        if($this->user()->isAdmin()) {
            $rules['user_id'] = 'nullable|exists:users,id';
        }
        return $rules;
    }

    /**
     * @return SupportMessageDto
     */
    public function getDto(): SupportMessageDto
    {
        $from_admin = $this->user()->isAdmin() && $this->has('user_id');
        $receiver = $from_admin ? User::find($this->get('user_id')) : $this->user();

        return new SupportMessageDto([
            'content' => $this->get('content'),
            'user' => $receiver,
            'from_admin' => $from_admin,
        ]);
    }
}
