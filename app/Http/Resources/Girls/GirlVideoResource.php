<?php

namespace App\Http\Resources\Girls;

use Illuminate\Http\Resources\Json\JsonResource;

class GirlVideoResource extends JsonResource
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
            'url' => $this->getUrl(),
            'thumb' => $this->getUrl('videothumbs'),
            'girl' => new GirlPublicResource($this->model),
        ];
    }
}
