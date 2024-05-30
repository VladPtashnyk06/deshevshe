<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['nullable'],
            'payment_method_id' => ['required'],
            'user_name' => ['required', 'string'],
            'user_last_name' => ['required', 'string'],
            'user_phone' => ['required', 'string'],
            'user_email' => ['nullable', 'string'],
            'password' => ['nullable'],
            'password_confirmation' => ['nullable'],
            'comment' => ['nullable'],
            'total_price' => ['required'],
            'currency' => ['required', 'string'],
            'cost_delivery' => ['required', 'string'],
            'NovaPoshtaRegion' => ['nullable', 'string'],
            'MeestRegion' => ['nullable', 'string'],
            'NovaPoshtaCityInput' => ['nullable', 'string'],
            'MeestCityInput' => ['nullable', 'string'],
            'NovaPoshtaBranchesInput' => ['nullable', 'string'],
            'MeestBranchesInput' => ['nullable', 'string'],
            'branchRefHidden' => ['nullable', 'string'],
            'branchID' => ['nullable', 'string'],
            'cityRefHidden' => ['nullable', 'string'],
            'cityId' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'delivery_type' => ['required', 'string']
        ];
    }
}
