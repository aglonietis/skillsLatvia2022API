<?php

namespace App\Http\Requests;

use App\Constants\DeliveryTypes;

/**
 * @OA\Schema()
 */
class DeliveryUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(property="source_address", type="string", example="Valmiera iela 5"), 
     * @OA\Property(property="delivery_address", type="string", example="Rigas iela 99"), 
     * @OA\Property(property="phone_number", type="string", example="291042402"), 
     * @OA\Property(property="email", type="string", example="test@dgtcloud.lv"), 
     * @OA\Property(property="size_depth", type="integer", example="123", description="value in milimeters"), 
     * @OA\Property(property="size_width", type="integer", example="423", description="value in milimeters"), 
     * @OA\Property(property="size_height", type="integer", example="423", description="value in milimeters"), 
     * @OA\Property(property="weight", type="integer", example="234", description="value in grams") 
     *
     * @return array
     */
    public function rules()
    {
        return [
            'source_address' => 'sometimes|string|min:1|max:500',
            'delivery_address' => 'sometimes|string|min:1|max:500',
            'phone_number' => 'sometimes|string|min:1|max:191',
            'email' => 'sometimes|string|email|min:1|max:191',
            'size_depth' => 'sometimes|integer|min:1|max:1000000',
            'size_width' => 'sometimes|integer|min:1|max:1000000',
            'size_height' => 'sometimes|integer|min:1|max:1000000',
            'weight' => 'sometimes|integer|min:1|max:1000000',
            'status' => 'sometimes|string|in:'.implode(',', [DeliveryTypes::ACCEPTED,DeliveryTypes::IN_SORT_CENTER,DeliveryTypes::ON_ROAD,DeliveryTypes::DELIVERED])
        ];
    }
}
