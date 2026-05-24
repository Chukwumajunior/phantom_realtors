<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Enums\ServiceCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isMerchant() &&
               $this->route('service')->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:20'],
            'category' => ['required', Rule::enum(ServiceCategory::class)],
            'currency' => ['nullable', Rule::enum(Currency::class)],
            'price_from' => ['nullable', 'numeric', 'min:0'],
            'price_to' => ['nullable', 'numeric', 'min:0', 'gte:price_from'],
            'is_negotiable' => ['boolean'],
            'service_area' => ['nullable', 'string', 'max:255'],
            'highlights' => ['nullable', 'array'],
            'images' => ['nullable', 'array', 'max:4'],
            'images.*' => ['image', 'max:3072'],
        ];
    }
}
