<?php

namespace App\Http\Requests;

use App\Constants\DeliveryTypes;

class DeliveryCourierUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
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
