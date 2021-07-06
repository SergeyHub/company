<?php

namespace App\Http\Requests\Agencies;

use App\DTO\Agencies\AgencyDto;
use App\Rules\CheckTranslations;
use App\ValueObjects\Translation;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'name' => 'required|min:2|max:30',
            'phone' => 'required|min:6|max:20',
            'contact_methods.*' => 'nullable|exists:contact_methods,id',
            'description' => [
                'required',
                new CheckTranslations(10, 1024),
            ],
        ];
    }

    /**
     * @return AgencyDto
     */
    public function getDto(): AgencyDto
    {
        $translations_to_vo = function (array $translations) {
            return array_map(function ($locale, $value) {
                return new Translation($locale, $value);
            }, array_keys($translations), array_values($translations));
        };

        return new AgencyDto([
            'name' => $this->get('name'),
            'phone' => $this->get('phone'),
            'description' => $translations_to_vo($this->get('description')),
            'contact_methods' => $this->get('contact_methods'),
            'geographies' => $this->get('geographies'),
            'countries' => $this->get('countries'),
            'profile_site' => $this->get('profile_site'),
        ]);
    }
}
