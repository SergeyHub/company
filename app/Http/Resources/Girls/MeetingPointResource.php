<?php

namespace App\Http\Resources\Girls;

use Illuminate\Http\Resources\Json\JsonResource;

class MeetingPointResource extends JsonResource
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
            'type' => $this->type,
            'place' => $this->place,
        ];
    }
}
