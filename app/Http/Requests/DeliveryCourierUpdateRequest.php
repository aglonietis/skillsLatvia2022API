<?php

namespace App\Http\Requests;

use App\Constants\DeliveryTypes;

/**
 * @OA\Schema()
 */
class DeliveryCourierUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @OA\Property(property="status", type="string", example="delivered", description="Status of the delivery. Availble values: accepted, on_road, in_sorting_center, delivered, ")
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => 'required|string|in:'.implode(',', [DeliveryTypes::ACCEPTED,DeliveryTypes::IN_SORT_CENTER,DeliveryTypes::ON_ROAD,DeliveryTypes::DELIVERED])
        ];
    }
}
