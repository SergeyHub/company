<?php

namespace App\Entity\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Blog extends Model implements HasMedia
{

    use \Astrotomic\Translatable\Translatable;
    use HasMediaTrait;
    use SoftDeletes;

    public $translatedAttributes = ['title', 'content', 'short_description'];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumbs')
            ->fit(Manipulations::FIT_CROP, 367, 277)
            ->quality(80)
            ->performOnCollections('cover');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function cover()
    {
        return $this->morphOne(config('medialibrary.media_model'), 'model')
            ->where('collection_name', 'cover');
    }

}
