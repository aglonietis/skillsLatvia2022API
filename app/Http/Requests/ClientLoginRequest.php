<?php

namespace App\Http\Requests;

class ClientLoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|min:1|max:191',
            'password' => 'required|string|min:5|max:191',
        ];
    }
}
