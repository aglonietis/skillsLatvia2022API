<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *   @OA\Schema( 
 *       @OA\Property(property="status", type="string", example="delivered"), 
 *       @OA\Property(property="created_at", type="string", example="2022-04-20T22:00:05T0.0000Z"),
 *   ) 
 */
class StatusResource extends JsonResource
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
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }
}
