<?php

namespace App\Http\Requests;

class SortingCenterStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
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
