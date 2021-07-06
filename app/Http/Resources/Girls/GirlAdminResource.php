<?php

namespace App\Http\Resources\Girls;

use Illuminate\Http\Resources\Json\JsonResource;

class GirlAdminResource extends JsonResource
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
            'country' => $this->country_id,
            'age' => $this->age,
            'city' => $this->city_id ? $this->city->name : null,
            'country_name' => $this->country_id ? $this->country->name : null,
            'country_slug' => $this->country_id ? $this->country->slug : null,
            'city_name' => $this->city_id ? $this->city->name : null,
            'city_slug' => $this->city_id ? $this->city->slug : null,
            'avatar' => $this->avatar ? $this->avatar->getUrl('thumbs') : null,
            'status' => $this->status,
            'verified' => $this->verified,
            'rejected_reason' => $this->rejected_reason,
            'rejected_verification_reason' => $this->rejected_verification_reason,
            'user_id' => $this->user_id,
            'vip' => $this->vip,
            'vip_end_date' => $this->vip_end_date,
            'vip_orders' => $this->vipOrders()->with('bill')->get(),
            'vip_orders_amount' => $this->vipOrders->reduce(function($amount, $order) {
                return $amount + is_object($order->bill) ?  $order->bill->amount : 0;
            }, 0),

            'documents' => $this->document()->with('photo')->get()->map(function ($document) {
                return [
                    'id' => $document->id,
                    'url' => $document->photo->getUrl(),
                    'created_at' => $document->created_at
                ];
            }),
            'user' => $this->user,
            'created_at' => $this->created_at,
            'reviews_count' => $this->reviews->count(),
            'client_applications_count' => $this->clientApplications->count(),
            'verified_at' => $this->verified_at,
            'ready_for_travels' => $this->ready_for_travels,
        ];
    }
}
