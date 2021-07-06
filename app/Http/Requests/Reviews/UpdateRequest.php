<?php

namespace App\Http\Requests\Reviews;

use App\DTO\Reviews\ReviewsCreateDto;
use App\Entity\Bill\Currency\Currency;
use App\Entity\Geo\Country\Country;
use App\Entity\Review\Review;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'review' => 'required|string',
            'nickname' => 'required|min:2|max:20|alpha_dash',
            'email' => 'required|email',
            'meeting_date' => 'required',
            'duration' => 'required|int',
            'meeting_city' => 'required|string',
            'duration_type' =>[
                Rule::in(Review::DURATION_TYPES)
            ],
            'price' => 'required|int',
            'country' => 'required|exists:countries,id',
            'currency' => 'required|exists:currencies,id',
            'published' => 'required|bool',
        ];
    }

    public function getDto(): ReviewsCreateDto
    {
        return new ReviewsCreateDto([
            'review' =>  $this->get('review'),
            'nickname' => $this->get('nickname'),
            'email' => $this->get('email'),
            'meeting_date' => $this->get('meeting_date'),
            'duration' => $this->get('duration'),
            'meeting_city' => $this->get('meeting_city'),
            'duration_type' => $this->get('duration_type'),
            'price' => $this->get('price'),
            'country' =>  Country::find($this->get('country')),
            'currency' => Currency::find($this->get('currency')),
            'published' => $this->get('published'),
        ]);
    }
}
