<?php

namespace App\Http\Requests;

use App\Constants\RoleTypes;


/**
 * @OA\Schema()
 */
class UserStoreRequest extends BaseRequest
{
   /**
     *  Get the validation rules that apply to the request.
     *
     * @OA\Property(property="email", type="string", example="user1@mail.com"),
     * @OA\Property(property="password", type="string", example="PassWord12345"),
     * @OA\Property(property="name", type="string", example="Gibril"),
     * @OA\Property(property="surname", type="string", example="Pavlovic"),
     * @OA\Property(property="role", type="string", example="admin", description="Role of the user. Allowed role types: admin, courier, client"),
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
            'role' => 'required|string|in:'.implode(',', [RoleTypes::ADMIN,RoleTypes::CLIENT,RoleTypes::COURIER])
        ];
    }
}
