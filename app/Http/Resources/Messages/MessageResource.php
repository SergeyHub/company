<?php

namespace App\Http\Resources\Messages;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'content' => $this->content,
            'user_from_id' => $this->user_from_id,
            'user_to_id' => $this->user_to_id,
            'read' =>  $this->read,
            'created_at' => $this->created_at,
            'dialog_id' => $this->dialog_id,
        ];
    }
}
