<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderSmallRequest extends FormRequest
{
    /**
     * @return void
     */
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
            'delivery_method_id' => ['nullable',],
            'payment_method_id' => ['required'],
            'delivery_address_id' => ['nullable'],
            'user_name' => ['required', 'string'],
            'user_last_name' => ['required', 'string'],
            'user_phone' => ['required', 'regex:/^\+380(39|67|68|96|97|98|50|66|95|99|63|73|93)\d{7}$/'],
            'user_email' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
