<?php
namespace App\Http\Resources\Settings;

use Illuminate\Http\Resources\Json\JsonResource;

class VipTariffResource extends JsonResource
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
            'month_cost' => $this->month_cost,
            'year_cost' => $this->year_cost,
            'description' => $this->description,
            'name' => $this->name,
        ];
    }
}
