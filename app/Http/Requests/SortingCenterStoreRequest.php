<?php

namespace App\Http\Requests;

/**
 * @OA\Schema()
 */
class SortingCenterStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @OA\Property(property="name", type="string", example="Kapital sorting"), 
     * @OA\Property(property="address", type="string", example="Valnu iela 56"),
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:1|max:191|unique:sorting_centers',
            'address' => 'required|string|min:1|max:500',
        ];
    }
}
