<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Entity\Geo\City{
/**
 * App\Entity\Geo\City\CityTranslation
 *
 * @property int $id
 * @property int $city_id
 * @property string $name
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\CityTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\CityTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\CityTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\CityTranslation whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\CityTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\CityTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\CityTranslation whereName($value)
 */
	class CityTranslation extends \Eloquent {}
}

namespace App\Entity\Geo\City{
/**
 * App\Entity\Geo\City\City
 *
 * @property int $id
 * @property string|null $slug
 * @property int $country_id
 * @property int $status
 * @property-read \App\Entity\Geo\Country\Country $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Geo\City\CityTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\City\City withTranslation()
 */
	class City extends \Eloquent {}
}

namespace App\Entity\Geo\Country{
/**
 * App\Entity\Geo\Country\Country
 *
 * @property int $id
 * @property string|null $slug
 * @property int $status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Geo\City\City[] $cities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Geo\Country\CountryTranslation[] $translations
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country orderByTranslation($key, $sortmethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\Country withTranslation()
 */
	class Country extends \Eloquent {}
}

namespace App\Entity\Geo\Country{
/**
 * App\Entity\Geo\Country\CountryTranslation
 *
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property string $locale
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\CountryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\CountryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\CountryTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\CountryTranslation whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\CountryTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\CountryTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Geo\Country\CountryTranslation whereName($value)
 */
	class CountryTranslation extends \Eloquent {}
}

namespace App\Entity\User{
/**
 * App\Entity\User\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $email_verified_at
 * @property string $password
 * @property string $status
 * @property string $role
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\User\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Entity\Girl{
/**
 * App\Entity\Girl\Girl
 *
 * @property int $id
 * @property string|null $about
 * @property string|null $phone
 * @property int|null $age
 * @property int|null $city_id
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl whereAbout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Entity\Girl\Girl whereUserId($value)
 */
	class Girl extends \Eloquent {}
}

