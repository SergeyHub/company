<?php

namespace App\Http\Requests\Girls;

use App\DTO\Girls\GirlCreateDto;
use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Entity\Options\Body\Body;
use App\Entity\Options\BodyHair\BodyHair;
use App\Entity\Options\Ethnicity\Ethnicity;
use App\Entity\Options\Nationality\Nationality;
use App\Entity\Options\Orientation\Orientation;
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
            'name' => 'required',
            'phone' => 'required',
            'about' => 'nullable',
            'age' => 'nullable|integer|min:18|max:100',
            'country' => 'required|exists:countries,id',
            'city' => [
                'required',
                Rule::exists('cities', 'id')
                    ->where('country_id', $this->get('country'))
            ],
            'nationality' => 'nullable|exists:nationalities,id',
            'eye' => 'nullable|exists:eyes,id',
            'hair' => 'nullable|exists:hairs,id',
            'weight' => 'nullable|integer|min:0|max:999',
            'height' => 'nullable|integer|min:0|max:999',
            'bust' => 'nullable|integer|min:0|max:999',
            'waist' => 'nullable|integer|min:0|max:999',
            'hip' => 'nullable|integer|min:0|max:999',
        ];
    }

    public function getDto(): GirlCreateDto
    {
        return new GirlCreateDto([
            'name' => $this->get('name'),
            'phone' => $this->get('phone'),
            'age' => $this->get('age'),
            'country' => Country::find($this->get('country')),
            'city' => City::find($this->get('city')),
            'nationality' => Nationality::find($this->get('nationality')),
            'orientation' => Orientation::find($this->get('orientation')),
            'body_hair' => BodyHair::find($this->get('body_hair')),
            'body' => Body::find($this->get('body')),
            'ethnicity' => Ethnicity::find($this->get('ethnicity')),
            'user' => $this->user(),
            'weight' => $this->get('weight'),
            'height' => $this->get('height'),
            'bust' => $this->get('bust'),
            'waist' => $this->get('waist'),
            'hip' => $this->get('hip'),
        ]);
    }

}
