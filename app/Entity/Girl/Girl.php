<?php

namespace App\Entity\Girl;

use App\Entity\Agency\Agency;
use App\Entity\Documents\Document;
use App\Entity\FavouriteGirl\FavouriteGirl;
use App\Entity\Geo\City\City;
use App\Entity\Geo\Country\Country;
use App\Entity\Options\Body\Body;
use App\Entity\Options\BodyHair\BodyHair;
use App\Entity\Options\ContactMethod\ContactMethod;
use App\Entity\Options\Ethnicity\Ethnicity;
use App\Entity\Options\Eye\Eye;
use App\Entity\Options\Geography\Geography;
use App\Entity\Options\Hair\Hair;
use App\Entity\Options\Language\Language;
use App\Entity\Options\Nationality\Nationality;
use App\Entity\Options\Orientation\Orientation;
use App\Entity\Options\Purpose\Purpose;
use App\Entity\Options\ReadyFor\ReadyFor;
use App\Entity\Options\WhatLike\WhatLike;
use App\Entity\ProfileSite\ProfileSite;
use App\Entity\User\User;
use App\Filters\BaseFilter;
use App\Entity\FakeReport\FakeReport;
use App\Entity\Review\Review;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use DB;
use App\Entity\ClientApplications\ClientApplication;
use App\Entity\Orders\OrderGirlVip;
use App\Notifications\FailedVerification;

class Girl extends Model implements HasMedia
{

    use HasMediaTrait, SoftDeletes;
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['about', 'dating_imagine'];

    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_CLOSED = 'closed';

    public const VERIFY_NOT = 'no';
    public const VERIFY_WAIT = 'wait';
    public const VERIFY_YES = 'yes';
    public const VERIFY_REJECTED = 'rejected';

    public const PUBLIC_PHOTOS = 'public';
    public const PUBLIC_VIDEOS = 'videos';

    public const TYPE_GIRLS = 'girls';
    public const TYPE_TRAVELS = 'travels';
    public const TYPE_DATING = 'dating';

    public const FILTER_SECTION_TOP50 = 'top50';
    public const FILTER_SECTION_PORNSTARS = 'pornstars';
    public const FILTER_SECTION_REVIEWS = 'reviews';
    public const FILTER_SECTION_VIP = 'vip';
    public const FILTER_SECTION_AGENCIES = 'agencies';

    public const GIRL_TYPES = [
        self::TYPE_GIRLS,
        self::TYPE_TRAVELS,
        self::TYPE_DATING,
    ];

    public const FILTER_SECTIONS = [
        self::FILTER_SECTION_TOP50,
        self::FILTER_SECTION_PORNSTARS,
        self::FILTER_SECTION_VIP,
        self::FILTER_SECTION_REVIEWS,
        self::FILTER_SECTION_AGENCIES
    ];

    public $registerMediaConversionsUsingModelInstance = true;

    protected $fillable = [
        'name',
        'phone',
        'pornstar',
        'age',
        'country_id',
        'city_id',
        'user_id',
        'nationality_id',
        'body_id',
        'body_hair_id',
        'orientation_id',
        'ethnicity_id',
        'views',
        'status',
        'type',
        'vip'
    ];

    protected $dates = ['publish_end_date', 'vip_end_date'];

    protected $casts = [
        'pornstar' => 'boolean',
        'vip' => 'boolean',
    ];

    public function bookmarks() {
        return $this->hasMany(Bookmark::class);
    }

    public function setWaitVerify(): void
    {
        $this->verified = self::VERIFY_WAIT;

        $notifications = $this->user->notifications()
            ->where('type', FailedVerification::class)
            ->whereNull('read_at')
            ->get();

        foreach($notifications as $notification) {
            $notification->markAsRead();
        }

        $this->save();
    }

    public function setVerified(): void
    {
        $this->verified = self::VERIFY_YES;
        $this->verified_at = now();
        $this->save();
    }

    public function isWaitVerify(): bool
    {
        return $this->verified === self::VERIFY_WAIT;
    }

    public function isVerified(): bool
    {
        return $this->verified === self::VERIFY_YES;
    }

    public function isVerifyRejected(): bool
    {
        return $this->verified === self::VERIFY_REJECTED;
    }

    public function activate(): bool
    {
        // если опубликован, то считаем, что все поля заполнены и профиль активирован
        if($this->status == static::STATUS_PUBLISHED)
            return true;

        if($this->status == static::STATUS_ACTIVE)
            return true;

        // if fields filled then set active
        if($this->requiredFieldsFilled()) {
            $this->status = static::STATUS_ACTIVE;
            $this->save();
            return true;
        }

        return false;
    }

    public function isPornstar()
    {
        return !!$this->pornstar;
    }

    public function reject(string $reason)
    {
        $this->rejected_reason = $reason;
        $this->status = self::STATUS_REJECTED;
        return $this->saveOrFail();
    }

    public function rejectVerification($reason)
    {
        $this->rejected_verification_reason = $reason;
        $this->verified = self::VERIFY_REJECTED;
        return $this->saveOrFail();
    }

    public function requiredFieldsFilled(): bool
    {
        return $this->country_id && $this->name && $this->real_name && $this->getFirstMedia(self::PUBLIC_PHOTOS);
    }

    public function wait()
    {
        $this->status = static::STATUS_WAIT;
        $this->save();
    }

    public function publish()
    {
        if(!$this->requiredFieldsFilled())
            return false;
        $this->status = static::STATUS_PUBLISHED;
        $this->save();
        return true;
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    public function close()
    {
        $this->status = static::STATUS_CLOSED;
        $this->save();
    }

    public function view()
    {
        $this->views++;
        $this->save();
    }

    public function contactMethods()
    {
        return $this->belongsToMany(ContactMethod::class, 'contact_method_girls')
            ->using(ContactMethodGirl::class);
    }

    public function purposes()
    {
        return $this->belongsToMany(Purpose::class, 'purpose_girls')
            ->using(PurposeGirl::class);
    }

    public function favourites()
    {
        return $this->belongsToMany( User::class, 'favourite_girls')
            ->using(FavouriteGirl::class);
    }

    public function possibleCountries()
    {
        return $this->belongsToMany(Country::class, 'possible_country_girls')
            ->using(PossibleCountryGirl::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'language_girls')
            ->using(LanguageGirl::class);
    }

    public function geographies()
    {
        return $this->belongsToMany(Geography::class, 'geography_girls')
            ->using(GeographyGirl::class);
    }

    public function whatLikes()
    {
        return $this->belongsToMany(WhatLike::class, 'what_like_girls')
            ->using(WhatLikeGirl::class);
    }

    public function readyFors()
    {
        return $this->belongsToMany(ReadyFor::class, 'ready_for_girls')
            ->using(ReadyForGirl::class);
    }

    public function meetingPoints()
    {
        return $this->hasMany(GirlMeetingPoint::class, 'girl_id');
    }

    public function meetingWith()
    {
        return $this->hasMany(GirlMeetingWith::class, 'girl_id');
    }

    public function costs()
    {
        return $this->hasMany(GirlCost::class, 'girl_id');
    }

    public function eye()
    {
        return $this->belongsTo(Eye::class, 'eye_id');
    }

    public function hair()
    {
        return $this->belongsTo(Hair::class, 'hair_id');
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }

    public function ethnicity()
    {
        return $this->belongsTo(Ethnicity::class, 'ethnicity_id');
    }

    public function body()
    {
        return $this->belongsTo(Body::class, 'body_id');
    }

    public function bodyHair()
    {
        return $this->belongsTo(BodyHair::class, 'body_hair_id');
    }

    public function orientation()
    {
        return $this->belongsTo(Orientation::class, 'orientation_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class, 'agency_id');
    }

    public function document()
    {
        return $this->hasOne(Document::class, 'girl_id');
    }

    public function unverifyPhone(): void
    {
        $this->phone_verified = false;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->phone_auth = false;
        $this->saveOrFail();
    }

    public function extendPublicationDays(int $days)
    {
        if(!$this->publish_end_date) {
            $this->publish_end_date = now()->addDays($days);
        } else {
            $this->publish_end_date->addDays($days);
        }
        $this->save();
    }

    public function requestPhoneVerification(Carbon $now): string
    {
        if (empty($this->phone)) {
            throw new \DomainException('Phone number is empty.');
        }
        if (!empty($this->phone_verify_token) && $this->phone_verify_token_expire && $this->phone_verify_token_expire->gt($now)) {
            throw new \DomainException('Token is already requested.');
        }
        $this->phone_verified = false;
        $this->phone_verify_token = (string)random_int(10000, 99999);
        $this->phone_verify_token_expire = $now->copy()->addSeconds(300);
        $this->saveOrFail();

        return $this->phone_verify_token;
    }

    public function verifyPhone($token, Carbon $now): void
    {
        if ($token !== $this->phone_verify_token) {
            throw new \DomainException('Incorrect verify token.');
        }
        if ($this->phone_verify_token_expire->lt($now)) {
            throw new \DomainException('Token is expired.');
        }
        $this->phone_verified = true;
        $this->phone_verify_token = null;
        $this->phone_verify_token_expire = null;
        $this->saveOrFail();
    }

    public function vipOrders() {
        return $this->hasMany(OrderGirlVip::class);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumbs')
            ->fit(Manipulations::FIT_CROP, 322, 492)
            ->quality(70)
            ->watermark(public_path('/images/logo.png'))
            ->watermarkFit(Manipulations::FIT_STRETCH)
            ->watermarkPosition(Manipulations::POSITION_BOTTOM_LEFT)
            ->watermarkPadding(20)
            ->watermarkHeight(32)
            ->performOnCollections(self::PUBLIC_PHOTOS);

        $this->addMediaConversion('big')
            ->watermark(public_path('/images/logo.png'))
            ->quality(70)
            ->watermarkFit(Manipulations::FIT_STRETCH)
            ->watermarkPosition(Manipulations::POSITION_BOTTOM_LEFT)
            ->watermarkPadding(20)
            ->watermarkHeight(32)
            ->performOnCollections(self::PUBLIC_PHOTOS);

        $this->addMediaConversion('videothumbs')
            ->extractVideoFrameAtSecond(0)
            ->performOnCollections(self::PUBLIC_VIDEOS);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function avatar()
    {
        return $this->morphOne(config('medialibrary.media_model'), 'model')
            ->where('collection_name', static::PUBLIC_PHOTOS)
            ->where('custom_properties->avatar', true);
    }

    /*
     * Выборка по принадлежности модели к стране
     */
    public function scopeInCountry(Builder $builder, Country $country)
    {
        return $builder->where(function($query) use ($country) {
            $query->where('country_id', $country->id)
                ->orWhereHas('possibleCountries', function ($query) use ($country) {
                    $query->where('country_id', $country->id);
                });
        });
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->where('status', self::STATUS_PUBLISHED);
    }

    /**
     * @param Builder $builder
     * @param BaseFilter $filter
     * @return Builder
     */
    public function scopeFilter(Builder $builder, BaseFilter $filter)
    {
        return $filter->apply($builder);
    }

    public function profileSite()
    {
        return $this->morphOne(ProfileSite::class, 'model');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'model');
    }

    public function publishedReviews()
    {
        return $this->morphMany(Review::class, 'model')->where('published', true);
    }

    public function fakeReports()
    {
        return $this->hasMany(FakeReport::class);
    }

    public function profileActiveSite()
    {
        return $this->morphOne(ProfileSite::class, 'model')->where('status', ProfileSite::STATUS_ACTIVE);
    }

    public function clientApplications() {
        return $this->hasMany(ClientApplication::class);
    }

    public function getNextGirlAttribute()
    {
        return Girl::where('id', '>', $this->id)->where('status', self::STATUS_PUBLISHED)->min('id');
    }

    public function getPrevGirlAttribute()
    {
        return Girl::where('id', '<', $this->id)->where('status', self::STATUS_PUBLISHED)->max('id');
    }

    public static function nextGirl($id)
    {
        return Girl::select(['id', 'type', 'country_id', 'city_id'])->with(['country', 'city'])->where('id', '>', $id)->where('status', self::STATUS_PUBLISHED)->orderBy('id', 'asc');
    }

    public static function prevGirl($id)
    {
        return Girl::select(['id', 'type', 'country_id', 'city_id'])->with(['country', 'city'])->where('id', '<', $id)->where('status', self::STATUS_PUBLISHED)->orderBy('id', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function hiddenFor() {
        return $this->belongsToMany(User::class, 'hidden_girls', 'girl_id', 'user_id');
    }

    /**
     * @param int $count
     * @param int $excludeGirl
     * @param int|null $country_id
     * @param int|null $city_id
     * @return \Illuminate\Database\Query\Builder
     */
    public static function anotherGirls(int $count = 20, $excludeGirl = 0, int $country_id = null, int $city_id = null) {
        return Girl::orderBy(DB::raw(
            ($country_id !== null ? 'CASE country_id WHEN '. $country_id .' THEN 0 ELSE 1 END,' : '').
            ($city_id !== null ? 'CASE city_id WHEN '. $city_id .' THEN 0 ELSE 1 END ,' : '').
            'RAND()'
        ), 'desc')
            ->where('id', '<>', $excludeGirl)
            ->limit($count);

    }

    public function setVip() {
        $this->vip = 1;
    }

    public function extendVipDays($days) {
        if(!$this->vip_end_date) {
            $this->vip_end_date = now()->addDays($days);
        } else {
            $this->vip_end_date->addDays($days);
        }
    }

    public function removeVip() {
        $this->vip = 0;
    }
}
