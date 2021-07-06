<?php

namespace App\Http\Resources\Users;

use App\Http\Resources\Girls\GirlPublicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    /** @var string|null */
    protected $token;

    public function __construct($resource, string $token=null)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

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
            'type' => $this->type,
            'email' => $this->email,
            'status' => $this->status,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'receive_notifications' => $this->receive_notifications,
            'token' => $this->token,
            'email_verified_at' => $this->email_verified_at,
            'intercom_hash' => $this->getIntercomHash(),
            'girls' => GirlPublicResource::collection($this->ownGirls),
            'deleted_at' => $this->deleted_at
        ];
    }
}
