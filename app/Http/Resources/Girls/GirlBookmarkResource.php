<?php

namespace App\Http\Resources\Girls;

use Illuminate\Http\Resources\Json\JsonResource;

class GirlBookmarkResource extends JsonResource
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
            'content' => $this->content,
            'updated_at' => $this->updated_at
        ];
    }
}
