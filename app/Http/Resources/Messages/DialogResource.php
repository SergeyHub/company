<?php

namespace App\Http\Resources\Messages;

use App\Entity\User\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DialogResource extends JsonResource
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
            'userFirst' => $this->userFirst ? $this->userFirst->getMetaInfo() : null,
            'userSecond' => $this->userSecond ? $this->userSecond->getMetaInfo() : null,
            'lastMessage' => $this->lastMessage ? new MessageResource($this->lastMessage) : null,
            'last_message_time' => $this->last_message_time,
        ];
    }
}
