<?php

namespace App\Http\Requests\Messages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListDialogRequest extends FormRequest
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
            'dialog_id' => [
                'required',
                Rule::exists('dialogs', 'id')
                    ->where(function($query) {
                        $query->where('user_first', $this->user()->id)
                            ->orWhere('user_second', $this->user()->id);
                    })
            ]
        ];
    }
}
