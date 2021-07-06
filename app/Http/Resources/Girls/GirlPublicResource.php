<?php

namespace App\Http\Resources\Girls;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\Girl\GirlService;

class GirlPublicResource extends JsonResource
{
    protected $girlService;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $this->girlService = app()->make(GirlService::class);
        $top50 = $this->girlService->getTop50Girls();

        $girlId = $this->id;
        $isTop = $top50->contains(function($value, $key) use($girlId) {
            return $value['id'] == $girlId;
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'country' => $this->country_id,
            'about' => $this->about,
            'age' => $this->age,
            'city' => $this->city_id ? $this->city->name : null,
            'city_slug' => $this->city_id ? $this->city->slug : null,
            'country_name' => $this->country_id ? $this->country->name : null,
            'country_slug' => $this->country_id ? $this->country->slug : null,
            'avatar' => $this->avatar ? $this->avatar->getUrl('thumbs') : null,
            'profile_age' => now()->diffInDays($this->created_at),
            'cost' => $this->cost,
            'hidden' => auth('api')->user() && auth('api')->user()->hiddenGirls()->where('hidden_girls.girl_id', $this->id)->count() >= 1,
            'status' => $this->status,
            'bookmark' => auth('api')->user() ? new GirlBookmarkResource($this->bookmarks()->where('user_id', auth('api')->user()->id)->first()): null,
            'verified' => $this->verified,
            'type' => $this->type,
            'is_top' => $isTop,
            'vip' => $this->vip,
            'vip_end_date' => $this->vip_end_date,
            'reviews_count' => $this->publishedReviews->count(),
            'ready_for_travels' => $this->ready_for_travels,
        ];
    }
}
