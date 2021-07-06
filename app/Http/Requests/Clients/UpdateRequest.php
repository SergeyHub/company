<?php

namespace App\Http\Requests\Clients;

use App\DTO\Clients\ClientDto;
use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Entity\Options\Nationality\Nationality;
use App\Rules\CheckTranslations;
use App\ValueObjects\Translation;
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
        $phone_rules = ['required', 'min:6', 'max:20'];
        if(!$this->user()->isAdmin()) {
            $phone_rules[] = Rule::exists('phone_activates', 'phone')
                ->where('user_id', $this->user()->id)
                ->where('success', 1);
        }
        return [
            'name' => 'required|min:2|max:20|alpha',
            'phone' => $phone_rules,
            'about' => [
                'required',
                new CheckTranslations(0,2500),
            ],
            'age' => 'nullable|integer|min:18|max:100',
            'country' => 'required|exists:countries,id',
            'city' => [
                'required',
                Rule::exists('cities', 'id')
                    ->where('country_id', $this->get('country'))
            ],
            'nationality' => 'required|exists:nationalities,id',
        ];
    }

    public function getDto(): ClientDto
    {
        $translations_to_vo = function (array $translations) {
            return array_map(function ($locale, $value) {
                return new Translation($locale, $value);
            }, array_keys($translations), array_values($translations));
        };

        return new ClientDto([
            'name' => $this->get('name'),
            'phone' => $this->get('phone'),
            'about' => $translations_to_vo($this->get('about')),
            'age' => $this->get('age'),
            'country' => Country::find($this->get('country')),
            'city' => City::find($this->get('city')),
            'nationality' => Nationality::find($this->get('nationality')),
        ]);
    }
}
