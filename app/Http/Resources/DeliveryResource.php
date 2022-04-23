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
 *       @OA\Property(property="size_depth", type="integer", example="123", description="value in milimeters"), 
 *       @OA\Property(property="size_width", type="integer", example="423", description="value in milimeters"), 
 *       @OA\Property(property="size_height", type="integer", example="423", description="value in milimeters"), 
 *       @OA\Property(property="weight", type="integer", example="234", description="value in grams"),
 *       @OA\Property(property="status_history", type="array", @OA\Items(ref="#/components/schemas/StatusResource")),
 *   ) 
 */
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
            "user_id" => $this->user_id,
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
