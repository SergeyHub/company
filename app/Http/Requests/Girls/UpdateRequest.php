<?php

namespace App\Http\Requests\Girls;

use App\DTO\Girls\DurationGirl;
use App\DTO\Girls\GirlCreateDto;
use App\Entity\Bill\Currency\Currency;
use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Entity\Girl\GirlMeetingWith;
use App\Entity\Options\Body\Body;
use App\Entity\Options\BodyHair\BodyHair;
use App\Entity\Options\Ethnicity\Ethnicity;
use App\Entity\Options\Eye\Eye;
use App\Entity\Options\Hair\Hair;
use App\Entity\Options\Language\Language;
use App\Entity\Options\Nationality\Nationality;
use App\Entity\Options\Orientation\Orientation;
use App\Rules\CheckTranslations;
use App\Rules\DurationCostsRule;
use App\Rules\GirlCostsRule;
use App\Rules\GirlPornstarRule;
use App\Rules\MeetingPointsRule;
use App\ValueObjects\GirlCost;
use App\ValueObjects\MeetingPoint;
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
        $rules =  [
            'name' => 'required|min:2|max:20|regex:/^[a-zA-Z\s]+$/',
            'real_name' => 'required|min:2|max:20|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|min:6|max:20',
            'pornstar' => [new GirlPornstarRule($this->id)],
            'about' => [
                'required',
                new CheckTranslations(0, 2048),
            ],
            'age' => 'nullable|integer|min:18|max:100',
            'country' => 'required|exists:countries,id',
            'city' => [
                'required',
                Rule::exists('cities', 'id')
                    ->where('country_id', $this->get('country'))
            ],
            'nationality' => 'required|exists:nationalities,id',
            'orientation' => 'required|exists:orientations,id',
            'body_hair' => 'required|exists:body_hairs,id',
            'body' => 'required|exists:bodies,id',
            'ethnicity' => 'required|exists:ethnicities,id',
            'eye' => 'nullable|exists:eyes,id',
            'hair' => 'nullable|exists:hairs,id',
            'languages.*' => 'nullable|exists:languages,id',
            'possible_countries.*' => 'nullable|exists:countries,id',
            'contact_methods.*' => 'nullable|exists:contact_methods,id',
            'meeting_points' => [ new MeetingPointsRule() ],
            'meeting_with.*' => [
                'nullable',
                Rule::in(GirlMeetingWith::getTypesList()),
            ],
            'costs' => [ new GirlCostsRule() ],
            'weight' => 'required|integer|min:30|max:240',
            'height' => 'required|integer|min:130|max:240',
            'ready_for_travels' => 'nullable|boolean',
        ];

        if ($this->user()->isAdmin()) {
            $rules['vip'] =  'boolean';
        }

        return $rules;
    }

    public function messages() {
        return [
            'name.regex' => __('validation.only_english', ['attribute' => 'name']),
            'real_name.regex' => __('validation.only_english', ['attribute' => 'real_name'])
        ];
    }

    public function getDto(): GirlCreateDto
    {
        $translations_to_vo = function (array $translations) {
            return array_map(function ($locale, $value) {
                return new Translation($locale, $value);
            }, array_keys($translations), array_values($translations));
        };

        $arr = [
            'name' => $this->get('name'),
            'real_name' => $this->get('real_name'),
            'phone' => $this->get('phone'),
            'pornstar' => $this->get('pornstar'),
            'about' => $translations_to_vo($this->get('about')),
            'age' => $this->get('age'),
            'country' => Country::find($this->get('country')),
            'city' => City::find($this->get('city')),
            'nationality' => Nationality::find($this->get('nationality')),
            'orientation' => Orientation::find($this->get('orientation')),
            'body_hair' => BodyHair::find($this->get('body_hair')),
            'body' => Body::find($this->get('body')),
            'ethnicity' => Ethnicity::find($this->get('ethnicity')),
            'eye' => Eye::find($this->get('eye')),
            'hair' => Hair::find($this->get('hair')),
            'languages' => $this->get('languages'),
            'geographies' => $this->get('geographies'),
            'what_likes' => $this->get('what_likes'),
            'ready_fors' => $this->get('ready_fors'),
            'weight' => $this->get('weight'),
            'height' => $this->get('height'),
            'bust' => $this->get('bust'),
            'waist' => $this->get('waist'),
            'hip' => $this->get('hip'),
            'possible_countries' => $this->get('possible_countries'),
            'contact_methods' => $this->get('contact_methods'),
            'meeting_points' => array_map(function (array $row) {
                return new MeetingPoint($row['type'], $row['place']);
            }, $this->get('meeting_points')),
            'costs' => array_map(function (array $row) {
                return new GirlCost(
                    $row['duration'],
                    $row['currency_id'],
                    $row['amount']
                );
            }, $this->get('costs')),
            'meeting_with' => $this->get('meeting_with'),
            'profile_site' => $this->get('profile_site'),
            'ready_for_travels' => $this->get('ready_for_travels'),
        ];
        if ($this->user()->isAdmin()) {
            $arr['vip'] = $this->get('vip');
        }
        return new GirlCreateDto($arr);
    }

}
