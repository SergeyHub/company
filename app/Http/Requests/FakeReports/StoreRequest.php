<?php

namespace App\Http\Requests\FakeReports;

use App\DTO\FakeReports\FakeReportsCreateDto;
use App\Entity\Girl\Girl;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'report' => 'required|string',
            'name' => 'required|min:2|max:20|alpha_dash',
            'email' => 'required|email',
            'girl' => 'required|exists:girls,id',
        ];
    }

    public function getDto(): FakeReportsCreateDto
    {
        return new FakeReportsCreateDto([
            'report' =>  $this->get('report'),
            'name' => $this->get('name'),
            'email' => $this->get('email'),
            'girl' => Girl::find($this->get('girl')),
        ]);
    }
}
