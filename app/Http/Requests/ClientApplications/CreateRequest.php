<?php

namespace App\Http\Requests\ClientApplications;

use Illuminate\Foundation\Http\FormRequest;
use App\DTO\ClientApplications\ClientApplicationDto;
use App\Entity\User\User;
use App\Entity\Girl\Girl;

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
            'content' => 'required|min:1|max:300',
            'user_to' => 'required|exists:users,id',
            'girl_id' => 'required|exists:girls,id',
            'phone' => 'string|min:5|max:15',
            'recall' => 'boolean',
            'meeting_date' => 'date'
        ];
    }

    public function getDto(): ClientApplicationDto
    {
        return new ClientApplicationDto([
            'user_from' => $this->user(),
            'user_to' => User::find($this->get('user_to')),
            'girl' => Girl::find($this->get('girl_id')),
            'meeting_date' => new \Carbon\Carbon($this->get('meeting_date')),
            'phone' => $this->get('phone'),
            'recall' => (boolean)$this->get('recall'),
            'content' => $this->get('content'),
        ]);
    }
}
