<?php

namespace App\Http\Requests;

/**
 * @OA\Schema()
 */
class SortingCenterUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @OA\Property(property="name", type="string", example="Kapital sorting"), 
     * @OA\Property(property="address", type="string", example="Valnu iela 56"),
     *
     * @return array
     */
    public function rules()
    {
        $sortingCenter = $this->route('center');

        return [
            'name' => 'sometimes|string|min:1|max:191|unique:sorting_centers,name,'.$sortingCenter->id,
            'address' => 'sometimes|string|min:1|max:500',
        ];
    }
}
