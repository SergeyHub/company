<?php

namespace App\Entity\Agency;

use App\Entity\Agency\GeographyAgency;
use App\Entity\Geo\Country\Country;
use App\Entity\Girl\Girl;
use App\Entity\Options\ContactMethod\ContactMethod;
use App\Entity\Options\Geography\Geography;
use App\Entity\ProfileSite\ProfileSite;
use App\Entity\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Agency extends Model implements HasMedia
{

    use HasMediaTrait, SoftDeletes;
    use \Astrotomic\Translatable\Translatable;

    public $translatedAttributes = ['description'];

    public const STATUS_WAIT = 'wait';
    public const STATUS_PUBLISHED = 'published';

    public const PUBLIC_PHOTOS = 'default';

    public function publish(): bool
    {
        $this->status = self::STATUS_PUBLISHED;
        return $this->saveOrFail();
    }

    public function isWaitFill(): bool
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isPublished(): bool
    {
        return $this->status === self::STATUS_PUBLISHED;
    }


    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumbs')
            ->fit(Manipulations::FIT_CROP, 200, 200)
            ->quality(70)
            ->watermark(public_path('/images/logo.png'))
            ->watermarkFit(Manipulations::FIT_STRETCH)
            ->watermarkPosition(Manipulations::POSITION_BOTTOM_LEFT)
            ->watermarkPadding(20)
            ->watermarkHeight(32)
            ->performOnCollections(self::PUBLIC_PHOTOS);
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

    public function contactMethods()
    {
        return $this->belongsToMany(ContactMethod::class, 'contact_method_agencies')
            ->using(ContactMethodAgency::class);
    }

    public function geographies()
    {
        return $this->belongsToMany(Geography::class, 'geography_agencies')
            ->using(GeographyAgency::class);
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'country_agencies')
            ->using(CountryAgency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function girls()
    {
        return $this->hasMany(Girl::class, 'agency_id');
    }

    public function publishedGirls()
    {
        return $this->hasMany(Girl::class, 'agency_id')->where('status', Girl::STATUS_PUBLISHED);
    }

    public function profileSite()
    {
        return $this->morphOne(ProfileSite::class, 'model');
    }

    public function profileActiveSite()
    {
        return $this->morphOne(ProfileSite::class, 'model')->where('status', ProfileSite::STATUS_ACTIVE);
    }

}
