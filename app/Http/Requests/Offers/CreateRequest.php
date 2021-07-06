<?php

namespace App\Http\Requests\Offers;

use App\DTO\Offers\OfferDto;
use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Rules\CheckTranslations;
use App\ValueObjects\Translation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => [
                'required',
                new CheckTranslations(5, 255),
            ],
            'content' => [
                'required',
                new CheckTranslations(10, 1000),
            ],
            'country' => 'required|exists:countries,id',
            'city' => [
                'required',
                Rule::exists('cities', 'id')
                    ->where('country_id', $this->get('country'))
            ],
            'cost' => 'required|integer|min:1|max:1000000000',
        ];
    }

    public function getDto(): OfferDto
    {
        $translations_to_vo = function (array $translations) {
            return array_map(function ($locale, $value) {
                return new Translation($locale, $value);
            }, array_keys($translations), array_values($translations));
        };

        return new OfferDto([
            'name' => $translations_to_vo($this->get('name')),
            'content' => $translations_to_vo($this->get('content')),
            'client' => $this->user()->client,
            'country' => Country::find($this->get('country')),
            'city' => City::find($this->get('city')),
            'cost' => (int)$this->get('cost'),
        ]);
    }

}
