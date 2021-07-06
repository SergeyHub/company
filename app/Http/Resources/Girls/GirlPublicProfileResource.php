<?php

namespace App\Http\Resources\Girls;

use App\Entity\Girl\Girl;
use App\Http\Resources\Geo\CityGirlProfileResource;
use App\Http\Resources\Geo\CountryGirlProfileResource;
use App\Http\Resources\Reviews\PublicReviewsResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\Models\Media;

class GirlPublicProfileResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => $this->country ?: new CountryGirlProfileResource($this->country),
            'about' => $this->about,
            'age' => $this->age,
            'views' => $this->views,
            'profile_age' => now()->diffInDays($this->created_at),
            'created_at' => $this->created_at->format('d.m.Y'),
            'city' => $this->city ?: new CityGirlProfileResource($this->city),
            'eye' => $this->eye ? $this->eye->name : null,
            'hair' => $this->hair ? $this->hair->name : null,
            'nationality' => $this->nationality ? $this->nationality->name : null,
            'body' => $this->body ? $this->body->name : null,
            'body_hair' => $this->bodyHair ? $this->bodyHair->name : null,
            'orientation' => $this->orientation ? $this->orientation->name : null,
            'ethnicity' => $this->ethnicity_id ? $this->ethnicity->name : null,
            'height' => $this->height,
            'weight' => $this->weight,
            'bust' => $this->bust,
            'pornstar' => $this->pornstar,
            'waist' => $this->waist,
            'hip' => $this->hip,
            'vip' => $this->vip,
            'languages' => $this->languages->pluck('name'),
            'geographies' => $this->geographies->pluck('name'),
            'bookmark' => auth('api')->user() ? new GirlBookmarkResource($this->bookmarks()->where('user_id', auth('api')->user()->id)->first()) : null,
            'what_likes' => $this->whatLikes->pluck('name'),
            'ready_fors' => $this->readyFors->pluck('name'),
            'contact_methods' => $this->contactMethods->pluck('name'),
            'possible_countries' => $this->possibleCountries->pluck('name'),
            'phone_image' => $this->phone_image ? config('medialibrary.s3.domain') . '/' . $this->phone_image : null,
            'photos' => $this->getMedia(Girl::PUBLIC_PHOTOS)->map(function (Media $photo) {
                return [
                    'thumb' => $photo->getUrl('thumbs'),
                    'big' => $photo->getUrl('big')
                ];
            }),
            'hidden' => auth('api')->user() && auth('api')->user()->hiddenGirls()->where('hidden_girls.girl_id', $this->id)->count() >= 1,
            'videos' => $this->getMedia(Girl::PUBLIC_VIDEOS)->map(function (Media $video) {
                return [
                    'thumb' => $video->getUrl('videothumbs'),
                    'url' => $video->getUrl()
                ];
            }),
            'cost' => $this->cost,
            'user_id' => $this->user_id,
            'last_seen_at' =>  Carbon::parse($this->user->last_seen_at)->format('Y.m.d H:i:s'),
            'avatar' => $this->avatar ? $this->avatar->getUrl('thumbs') : null,
            'verified' => $this->verified,
            'costs' => GirlCostResource::collection($this->costs),
            'meeting_points' => MeetingPointResource::collection($this->meetingPoints),
            'reviews' => PublicReviewsResource::collection($this->publishedReviews),
            'meeting_with' => $this->meetingWith->pluck('type'),
            'profile_site' => $this->profileActiveSite,
            'next_girl' => Girl::nextGirl($this->id)->first(),
            'prev_girl' => Girl::prevGirl($this->id)->first(),
            'another_girls' => GirlPublicResource::collection(Girl::anotherGirls(12, $this->id, $this->country_id, $this->city_id)->get()),
            'ready_for_travels' => $this->ready_for_travels,
        ];
    }
}
