<?php

namespace App\Http\Requests;

use App\Constants\DeliveryTypes;

class DeliveryUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
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
