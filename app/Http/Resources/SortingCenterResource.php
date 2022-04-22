<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *   @OA\Schema( 
 *       @OA\Property(property="name", type="string", example="Kapital sorting"), 
 *       @OA\Property(property="address", type="string", example="Valnu iela 56"),
 *   ) 
 */
class SortingCenterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
