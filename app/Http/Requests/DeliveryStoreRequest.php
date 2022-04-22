<?php

namespace App\Http\Requests;

/**
 * @OA\Schema()
 */
class DeliveryStoreRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(property="source_address", type="string", example="Valmiera iela 5"), 
     * @OA\Property(property="delivery_address", type="string", example="Rigas iela 99"), 
     * @OA\Property(property="customer_id", type="string", example="19"), 
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
            'source_address' => 'required|string|min:1|max:500',
            'delivery_address' => 'required|string|min:1|max:500',
            'customer_id' => 'required|exists:users,id', // Require special validation for role type
            'phone_number' => 'required|string|min:1|max:191',
            'email' => 'required|string|email|min:1|max:191',
            'size_depth' => 'required|integer|min:1|max:1000000',
            'size_width' => 'required|integer|min:1|max:1000000',
            'size_height' => 'required|integer|min:1|max:1000000',
            'weight' => 'required|integer|min:1|max:1000000',
        ];
    }
}
