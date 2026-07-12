<?php

namespace App\Enums;

enum ProductCategory: string
{
    case Electricals = 'electricals';
    case Electronics = 'electronics';
    case BuildingMaterials = 'building_materials';
    case SanitaryWare = 'sanitary_ware';
    case Furniture = 'furniture';
    case CoolingSystems = 'cooling_systems';
    case Windows = 'windows';
    case Curtains = 'curtains';
    case WindowBlinds = 'window_blinds';
    case InteriorDecor = 'interior_decor';

    public function label(): string
    {
        return match ($this) {
            self::Electricals => 'Electricals',
            self::Electronics => 'Electronics',
            self::BuildingMaterials => 'Building Materials',
            self::SanitaryWare => 'Sanitary Ware',
            self::Furniture => 'Furniture',
            self::CoolingSystems => 'Cooling Systems',
            self::Windows => 'Windows',
            self::Curtains => 'Curtains',
            self::WindowBlinds => 'Window Blinds',
            self::InteriorDecor => 'Interior Decor',
        };
    }

    /**
     * Get all sub-categories for this category.
     */
    public function subCategories(): array
    {
        return ProductSubCategory::forCategory($this);
    }

    /**
     * Get full hierarchy for frontend consumption (JSON for Alpine.js).
     */
    public static function hierarchy(): array
    {
        return array_map(fn (self $cat) => [
            'value' => $cat->value,
            'label' => $cat->label(),
            'sub_categories' => array_map(fn (ProductSubCategory $sub) => [
                'value' => $sub->value,
                'label' => $sub->label(),
            ], $cat->subCategories()),
        ], self::cases());
    }
}
