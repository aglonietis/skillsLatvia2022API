<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *   @OA\Schema( 
 *       @OA\Property(property="source_address", type="string", example="Valmieras iela 15"), 
 *       @OA\Property(property="delivery_address", type="string", example="Rīgas iela 99"), 
 *       @OA\Property(property="phone_number", type="string", example="29214124"), 
 *       @OA\Property(property="email", type="string", example="admin@dgtcloud.lv"), 
 *       @OA\Property(property="uuid", type="string", example="LV-24124124k4"), 
 *       @OA\Property(property="tracking_uuid", type="string", example="k4k249k19k241"), 
 *       @OA\Property(property="status", type="string", example="delivered"), 
 *   ) 
 *
 */
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
            'tracking_uuid' => $this->tracking_uuid,
            'status' => $this->status
        ];
    }
}
