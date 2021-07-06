<?php

namespace App\Http\Resources\Blogs;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'slug' => $this->slug,
            'content' => $this->content,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'views' => $this->views,
            'cover' => $this->cover ? $this->cover->getUrl('thumbs') : null,
            'created_at' => $this->created_at
        ];
    }
}
