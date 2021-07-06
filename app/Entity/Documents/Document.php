<?php

namespace App\Entity\Documents;

use App\Entity\Girl\Girl;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Document extends Model implements HasMedia
{

    use HasMediaTrait;

    public const MEDIA_COLLECTION = 'photos';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function photo()
    {
        return $this->morphOne(config('medialibrary.media_model'), 'model')
            ->where('collection_name', static::MEDIA_COLLECTION);
    }

    public function girl()
    {
        return $this->belongsTo(Girl::class, 'girl_id');
    }

}
