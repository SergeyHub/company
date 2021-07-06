<?php

namespace App\Http\Resources\Bills;

use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
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
            'amount' => $this->amount,
            'created_at' => $this->created_at,
            'status' => $this->status,
            'payed_at' => $this->payed_at,
            'order' => $this->order,
            'type' => $this->getType()
        ];
    }
}
