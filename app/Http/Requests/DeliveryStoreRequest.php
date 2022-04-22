<?php

namespace App\Http\Requests;

class DeliveryStoreRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
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
