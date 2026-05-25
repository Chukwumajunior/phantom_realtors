<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Enums\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin() ||
               ($this->user()->isMerchant() && $this->route('product')->user_id === $this->user()->id);
    }

    protected function prepareForValidation(): void
    {
        if ($this->specifications && is_string($this->specifications)) {
            $specs = [];
            foreach (explode("\n", $this->specifications) as $line) {
                $line = trim($line);
                if ($line === '') continue;
                if (str_contains($line, ':')) {
                    [$key, $value] = explode(':', $line, 2);
                    $specs[trim($key)] = trim($value);
                } else {
                    $specs[$line] = '';
                }
            }
            $this->merge(['specifications' => $specs]);
        }
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
            'images' => ['nullable', 'array', 'max:4'],
            'images.*' => ['image', 'max:3072'],
        ];
    }
}
