<?php

namespace App\Http\Requests;

use App\Constants\RoleTypes;

class ClientStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:1|max:191',
            'surname' => 'required|string|min:1|max:191',
            'email' => 'required|string|email|unique:users|min:1|max:191',
            'password' => 'required|string|min:5|max:191',
        ];
    }
}
