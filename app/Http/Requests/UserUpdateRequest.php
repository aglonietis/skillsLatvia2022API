<?php

namespace App\Http\Requests;

use App\Constants\RoleTypes;

class UserUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = $this->route('user');

        return [
            'name' => 'sometimes|string|min:1|max:191',
            'surname' => 'sometimes|string|min:1|max:191',
            'email' => 'sometimes|string|email|unique:users,email,'. $user->id.'|min:1|max:191',
            'password' => 'sometimes|string|min:5|max:191',
            'role' => 'sometimes|string|in:'.implode(',', [RoleTypes::ADMIN,RoleTypes::CLIENT,RoleTypes::COURIER])
        ];
    }
}
