<?php

namespace App\Http\Resources\Reviews;

use App\Http\Resources\Girls\GirlPublicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicReviewsResource extends JsonResource
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
            'review' => $this->review,
            'nickname' => $this->nickname,
            'email' => $this->email,
            //'meeting_date' => $this->meeting_date ? $this->meeting_date->format('d.m.Y') : null,
            //'meeting_city' => $this->meeting_city,
            //'duration_type' => $this->duration_type,
            //'duration' => $this->duration,
            //'price' => $this->price,
            //'country' => $this->country->name,
            //'currency' => $this->currency->title,
            'girl' => new GirlPublicResource($this->model),
            'stars' => $this->stars,
            'created_at' => $this->created_at->format('Y-m-d')
        ];
    }
}
