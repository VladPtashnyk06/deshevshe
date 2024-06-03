<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderSmallRequest extends FormRequest
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
    /**
     * @return array{user_id: array{0: string}, delivery_method_id: array{0: string}, payment_method_id: array{0: string}, delivery_address_id: array{0: string}, user_name: array{0: string, 1: string}, user_last_name: array{0: string, 1: string}, user_phone: array{0: string, 1: string}, user_email: array{0: string, 1: string}}
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable'],
            'payment_method_id' => ['required'],
            'user_name' => ['required', 'string'],
            'user_last_name' => ['required', 'string'],
            'user_phone' => ['required', 'regex:/^\+380(39|67|68|96|97|98|50|66|95|99|63|73|93)\d{7}$/'],
            'user_email' => ['nullable', 'string'],
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
