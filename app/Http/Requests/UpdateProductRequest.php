<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id ?? $this->route('product');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products', 'code')->ignore($productId),
            ],
            'name' => ['required', 'string', 'max:150'],
            'unit' => ['required', 'string', 'max:30'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0', 'gte:purchase_price'],
            'description' => ['nullable', 'string'],
        ];
    }
}
