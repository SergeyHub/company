<?php

namespace App\Http\Resources\Clients;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Girls\GirlAdminResource;

class ClientApplicationResource extends JsonResource
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
            'client_id' => $this->client_id,
            'user_to' => $this->user_to,
            'girl_id' => $this->girl_id,
            'girl' => new GirlAdminResource($this->girl),
            'phone' => $this->phone,
            'recall' => (integer) $this->recall,
            'meeting_date' => $this->meeting_date,
            'dialog_id' => $this->dialog_id,
            'created_at' => $this->created_at
        ];
    }
}
