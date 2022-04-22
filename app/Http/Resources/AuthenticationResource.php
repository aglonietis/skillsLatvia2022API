<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

   /**
    *   @OA\Schema( 
    *       @OA\Property(property="plainTextToken", type="string", example="8faFrk2424Foawr21", description="token for the customer"), 
    *   ) 
    * 
    */

class AuthenticationResource extends JsonResource
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
