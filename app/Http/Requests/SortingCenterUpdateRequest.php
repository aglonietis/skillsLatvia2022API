<?php

namespace App\Http\Requests;

class SortingCenterUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
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
