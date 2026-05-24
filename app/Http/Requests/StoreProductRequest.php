<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Enums\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isMerchant();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'category' => ['required', Rule::enum(ProductCategory::class)],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', Rule::enum(Currency::class)],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'brand' => ['nullable', 'string', 'max:100'],
            'condition' => ['nullable', 'string', 'in:new,used,refurbished'],
            'specifications' => ['nullable', 'array'],
            'images' => ['required', 'array', 'min:1', 'max:4'],
            'images.*' => ['image', 'max:3072'],
        ];
    }
}
