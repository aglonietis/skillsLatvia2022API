<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'source_address' => $this->source_address,
            'delivery_address' => $this->delivery_address,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'uuid' => $this->uuid,
            'tracker_uuid' => $this->tracking_uuid,
            'status' => $this->status
        ];
    }
}
