<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderEditThirdRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_name' => ['required', 'string'],
            'user_middle_name' => ['nullable', 'string'],
            'user_last_name' => ['required', 'string'],
            'nova_poshta_region' => ['nullable', 'string'],
            'nova_poshta_region_ref' => ['nullable', 'string'],
            'nova_poshta_city_input' => ['nullable', 'string'],
            'nova_poshta_branches_input' => ['nullable', 'string'],
            'MeestRegion' => ['nullable', 'string'],
            'meestCityIdHidden' => ['nullable', 'string'],
            'MeestCityInput' => ['nullable', 'string'],
            'meestBranchIDHidden' => ['nullable', 'string'],
            'MeestBranchesInput' => ['nullable', 'string'],
            'city_ref' => ['nullable', 'string'],
            'UkrPoshtaRegion' => ['nullable', 'string'],
            'ukrPoshtaCityIdHidden' => ['nullable', 'string'],
            'UkrPoshtaCityInput' => ['nullable', 'string'],
            'ukrPoshtaBranchIDHidden' => ['nullable', 'string'],
            'UkrPoshtaBranchesInput' => ['nullable', 'string'],
            'delivery_type' => ['nullable', 'string'],
            'branch_ref' => ['nullable', 'string'],
            'branch_number' => ['nullable', 'string'],
            'district_ref' => ['nullable', 'string'],
            'district_input' => ['nullable', 'string'],
            'village_ref' => ['nullable', 'string'],
            'village_input' => ['nullable', 'string'],
            'street_ref' => ['nullable', 'string'],
            'street_input' => ['nullable', 'string'],
            'house' => ['nullable', 'string'],
            'flat' => ['nullable', 'string'],
        ];

    }

    public function authorize(): bool
    {
        return true;
    }
}
