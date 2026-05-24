<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Enums\PropertyCategory;
use App\Enums\PropertyType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isMerchant() &&
               $this->route('property')->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:50'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['nullable', Rule::enum(Currency::class)],
            'type' => ['required', Rule::enum(PropertyType::class)],
            'category' => ['required', Rule::enum(PropertyCategory::class)],
            'address' => ['required', 'string', 'max:500'],
            'country' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'lga' => ['nullable', 'string', 'max:100'],
            'bedrooms' => ['nullable', 'integer', 'min:0', 'max:50'],
            'bathrooms' => ['nullable', 'integer', 'min:0', 'max:50'],
            'toilets' => ['nullable', 'integer', 'min:0', 'max:50'],
            'area_sqft' => ['nullable', 'integer', 'min:0'],
            'year_built' => ['nullable', 'digits:4'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string'],
            'images' => ['nullable', 'array', 'max:4'],
            'images.*' => ['image', 'max:3072'],
        ];
    }
}
