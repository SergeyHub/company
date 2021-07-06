<?php

namespace App\Http\Requests\Reviews;

use App\DTO\Reviews\ReviewsCreateDto;
use App\Entity\Bill\Currency\Currency;
use App\Entity\Geo\Country\Country;
use App\Entity\Girl\Girl;
use App\Entity\Review\Review;
use App\Rules\CheckTranslations;
use App\ValueObjects\Translation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'review' => [
                'required',
                new CheckTranslations(10, 2048),
            ],
            'nickname' => 'required|min:2|max:20|alpha_dash',
            'email' => 'required|email',
            'stars' => 'integer|between:1,5',
            /*'meeting_date' => 'required',
            'duration' => 'required|int',
            'meeting_city' => [
                'required',
                new CheckTranslations(10, 200),
            ],
            'duration_type' =>[
                Rule::in(Review::DURATION_TYPES)
            ],
            'price' => 'required|int',
            'country' => 'required|exists:countries,id',
            'currency' => 'required|exists:currencies,id',*/
            'girl' => 'required|exists:girls,id',
        ];
    }

    public function getDto(): ReviewsCreateDto
    {
        $translations_to_vo = function (array $translations) {
            return array_map(function ($locale, $value) {
                return new Translation($locale, $value);
            }, array_keys($translations), array_values($translations));
        };

        return new ReviewsCreateDto([
            'review' => $translations_to_vo($this->get('review')),
            'nickname' => $this->get('nickname'),
            'email' => $this->get('email'),
            'stars' => $this->get('stars'),

            /*'meeting_date' => $this->get('meeting_date'),
            'duration' => $this->get('duration'),
            'meeting_city' => $translations_to_vo($this->get('meeting_city')),
            'duration_type' => $this->get('duration_type'),
            'price' => $this->get('price'),
            'country' =>  Country::find($this->get('country')),
            'currency' => Currency::find($this->get('currency')),*/
            'girl' => Girl::find($this->get('girl')),
        ]);
    }
}
