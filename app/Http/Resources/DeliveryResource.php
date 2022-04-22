<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
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
            "id" => $this->id,
            "customer_id" => $this->customer_id,
            "source_address" => $this->source_address,
            "delivery_address" => $this->delivery_address,
            "phone_number" => $this->phone_number,
            "email" => $this->email,
            "size_depth" => $this->size_depth,
            "size_width" =>  $this->size_width,
            "size_height" => $this->size_height,
            "weight" => $this->weight,
            "status" => $this->status,
            "uuid" => $this->uuid,
            "tracking_uuid" => $this->tracking_uuid,
            "status_history" => StatusResource::collection($this->statuses)
        ];
    }
}
