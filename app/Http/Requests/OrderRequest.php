<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        if (isset($this->user_phone)) {
            if (!str_starts_with($this->user_phone, '+380')) {
                if (str_starts_with($this->user_phone, '0')) {
                    $this->merge([
                        'user_phone' => '+38' . $this->user_phone,
                    ]);
                } else {
                    $this->merge([
                        'user_phone' => '+380' . $this->user_phone,
                    ]);
                }
            }
        }
    }
    public function rules(): array
    {
        return [
            'user_id' => ['nullable'],
            'payment_method_id' => ['required'],
            'user_name' => ['required', 'string'],
            'user_last_name' => ['required', 'string'],
            'user_phone' => ['required', 'regex:/^\+380(39|67|68|96|97|98|50|66|95|99|63|73|93)\d{7}$/'],
            'user_email' => ['nullable', 'string'],
            'password' => ['nullable'],
            'password_confirmation' => ['nullable'],
            'comment' => ['nullable'],
            'total_price' => ['required'],
            'currency' => ['required', 'string'],
            'cost_delivery' => ['required', 'string'],
            'NovaPoshtaRegion' => ['nullable', 'string'],
            'NovaPoshtaCityInput' => ['nullable', 'string'],
            'NovaPoshtaBranchesInput' => ['nullable', 'string'],
            'MeestRegion' => ['nullable', 'string'],
            'MeestCityInput' => ['nullable', 'string'],
            'MeestBranchesInput' => ['nullable', 'string'],
            'UkrPoshtaRegion' => ['nullable', 'string'],
            'UkrPoshtaCityInput' => ['nullable', 'string'],
            'UkrPoshtaBranchesInput' => ['nullable', 'string'],
            'branchRefHidden' => ['nullable', 'string'],
            'meestBranchIDHidden' => ['nullable', 'string'],
            'cityRefHidden' => ['nullable', 'string'],
            'meestCityIdHidden' => ['nullable', 'string'],
            'ukrPoshtaCityIdHidden' => ['nullable', 'string'],
            'ukrPoshtaBranchIDHidden' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'delivery_type' => ['required', 'string']
        ];
    }
}
