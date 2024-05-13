<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories'],
            'producer_id' => ['required', 'exists:producers'],
            'status_id' => ['required', 'exists:statuses'],
            'size_id' => ['required', 'exists:sizes'],
            'color_id' => ['required', 'exists:colors'],
            'package_id' => ['required', 'exists:packages'],
            'material_id' => ['required', 'exists:materials'],
            'characteristic_id' => ['required', 'exists:characteristics'],
            'review_id' => ['required', 'exists:reviews'],
            'title' => ['required'],
            'description' => ['required'],
            'quantity' => ['required', 'integer'],
            'code' => ['required', 'integer'],
            'model' => ['required'],
            'product_promotion' => ['boolean'],
            'top_product' => ['boolean'],
            'rec_product' => ['boolean'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
