<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderEditThirdRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_name' => ['required', 'string'],
            'user_last_name' => ['required', 'string'],
            'NovaPoshtaRegion' => ['nullable', 'string'],
            'NovaPoshtaCityInput' => ['nullable', 'string'],
            'NovaPoshtaBranchesInput' => ['nullable', 'string'],
            'MeestRegion' => ['nullable', 'string'],
            'meestCityIDHidden' => ['nullable', 'string'],
            'MeestCityInput' => ['nullable', 'string'],
            'meestBranchIDHidden' => ['nullable', 'string'],
            'MeestBranchesInput' => ['nullable', 'string'],
            'cityRefHidden' => ['nullable', 'string'],
            'UkrPoshtaRegion' => ['nullable', 'string'],
            'ukrPoshtaCityIdHidden' => ['nullable', 'string'],
            'UkrPoshtaCityInput' => ['nullable', 'string'],
            'ukrPoshtaBranchIDHidden' => ['nullable', 'string'],
            'UkrPoshtaBranchesInput' => ['nullable', 'string'],
            'branchRefHidden' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'delivery_type' => ['nullable', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
