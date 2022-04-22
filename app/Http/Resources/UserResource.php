<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 *   @OA\Schema( 
 *       @OA\Property(property="id", type="string", example="1"), 
 *       @OA\Property(property="name", type="string", example="vladislavs"), 
 *       @OA\Property(property="surname", type="string", example="kuznecovs"), 
 *       @OA\Property(property="email", type="string", example="admin@dgtcloud.lv"), 
 *       @OA\Property(property="role", type="string", example="admin"), 
 *       @OA\Property(property="created_at", type="string", example="2022-04-20T12:00:43T0.0000Z"), 
 *       @OA\Property(property="updated_at", type="string", example="2022-04-20T12:00:43T0.0000Z"), 
 *   ) 
 */
class UserResource extends JsonResource
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
