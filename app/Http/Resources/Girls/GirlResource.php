<?php

namespace App\Http\Resources\Girls;

use App\Entity\Girl\Girl;
use App\Http\Resources\Documents\DocumentResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\Models\Media;

class GirlResource extends JsonResource
{

    /** @var bool  */
    private $for_admin;

    public function __construct($resource, bool $for_admin=false)
    {
        parent::__construct($resource);
        $this->for_admin = $for_admin;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $locales = config('translatable.locales');

        $localize_attr = function (string $attr_name, $obj) use ($locales) {
            $translations = $obj->getTranslationsArray();
            $attr_translations = [];
            foreach ($locales as $locale) {
                $attr_translations[$locale] = isset($translations[$locale][$attr_name])
                    ? $translations[$locale][$attr_name] : null;
            }
            return $attr_translations;
        };


        $media_mapper = function (Media $photo) {
            return [
                'url' => $photo->getUrl('thumbs'),
                'id' => $photo->id,
                'avatar' => isset($photo->custom_properties['avatar'])
                    ? $photo->custom_properties['avatar']
                    : false
            ];
        };
        $media_video_mapper = function (Media $video) {
            return [
                'url' => $video->getUrl(),
                'id' => $video->id,
                'thumb' => $video->getUrl('videothumbs')
            ];
        };

        return [
            'id' => $this->id,
            'name' => $this->name,
            'real_name' => $this->real_name,
            'phone' => $this->phone,
            'pornstar' => $this->pornstar,
            'country' => $this->country_id,
            'eye' => $this->eye_id,
            'hair' => $this->hair_id,
            'about' => $localize_attr('about', $this),
            'age' => $this->age,
            'city' => $this->city_id,
            'nationality' => $this->nationality_id,
            'body' => $this->body_id,
            'body_hair' => $this->body_hair_id,
            'orientation' => $this->orientation_id,
            'ethnicity' => $this->ethnicity_id,
            'status' => $this->status,
            'views' => $this->views,
            'cover' => $this->hasMedia('cover') ? $this->getMedia('cover')[0]->getUrl() : null,
            'avatar' => $this->avatar ? $this->avatar->getUrl('thumbs') : null,
            'weight' => $this->weight,
            'height' => $this->height,
            'bust' => $this->bust,
            'waist' => $this->waist,
            'hip' => $this->hip,
            'vip' => $this->vip,
            'vip_end_date' => $this->vip_end_date,
            'possible_countries' => $this->possibleCountries,
            'languages' => $this->languages,
            'geographies' => $this->geographies,
            'what_likes' => $this->whatLikes,
            'ready_fors' => $this->readyFors,
            'contact_methods' => $this->contactMethods->pluck('id'),
            'meeting_points' => MeetingPointResource::collection($this->meetingPoints),
            'meeting_with' => $this->meetingWith->pluck('type'),
            'verified' => $this->verified,
            'document' => $this->document ? new DocumentResource($this->document) : null,
            'costs' => GirlCostResource::collection($this->costs),
            'rejected_reason' => $this->rejected_reason,
            'rejected_verification_reason' => $this->rejected_verification_reason,
            'photos' => $this->getMedia(Girl::PUBLIC_PHOTOS)->map($media_mapper),
            'videos' => $this->getMedia(Girl::PUBLIC_VIDEOS)->map($media_video_mapper),
            'profile_site' => $this->profileSite ? $this->profileSite->url : null,
            'ready_for_travels' => $this->ready_for_travels,
        ];
    }

}
