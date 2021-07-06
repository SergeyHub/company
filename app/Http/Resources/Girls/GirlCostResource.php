<?php

namespace App\Http\Resources\Girls;

use Illuminate\Http\Resources\Json\JsonResource;

class GirlCostResource extends JsonResource
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
            'amount' => $this->amount,
            'duration' => $this->duration,
            'currency' => $this->currency,
            'currency_id' => $this->currency_id,
        ];
    }
}
