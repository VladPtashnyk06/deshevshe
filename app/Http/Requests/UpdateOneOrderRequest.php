<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOneOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
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
            'delivery_type' => ['nullable', 'string'],
            'comment' => ['nullable', 'string'],
            'payment_method_id' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
