<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Enums\ServiceCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->merchantProfile !== null || $this->user()->isAdmin();
    }

    protected function prepareForValidation(): void
    {
        if ($this->category) {
            $cat = ServiceCategory::tryFrom($this->category);
            if ($cat) {
                $this->merge(['name' => $cat->label()]);
            }
        }

        if ($this->highlights && is_string($this->highlights)) {
            $this->merge([
                'highlights' => array_values(array_filter(array_map('trim', explode("\n", $this->highlights)))),
            ]);
        }
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
            'location_house_number' => ['required', 'string', 'max:50'],
            'location_street_name' => ['required', 'string', 'max:255'],
            'location_area' => ['required', 'string', 'max:100'],
            'location_lga' => ['required', 'string', 'max:100'],
            'location_state' => ['required', 'string', 'max:100'],
            'location_zip_code' => ['nullable', 'string', 'max:20'],
            'location_country' => ['required', 'string', 'max:100'],
            'images' => ['required', 'array', 'min:1', 'max:4'],
            'images.*' => ['image', 'max:3072'],
        ];
    }
}
