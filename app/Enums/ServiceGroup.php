<?php

namespace App\Enums;

enum ServiceGroup: string
{
    case DesignPlanning = 'design_planning';
    case ProjectSiteManagement = 'project_site_management';
    case StructuralConstruction = 'structural_construction';
    case ElectricalMechanical = 'electrical_mechanical';
    case FinishingInterior = 'finishing_interior';
    case SecuritySafety = 'security_safety';
    case HouseholdDomestic = 'household_domestic';

    public function label(): string
    {
        return match ($this) {
            self::DesignPlanning => 'Design & Planning',
            self::ProjectSiteManagement => 'Project & Site Management',
            self::StructuralConstruction => 'Structural & Construction Works',
            self::ElectricalMechanical => 'Electrical, Mechanical & Technical Installations',
            self::FinishingInterior => 'Finishing & Interior Works',
            self::SecuritySafety => 'Security & Safety Services',
            self::HouseholdDomestic => 'Household & Domestic Services',
        };
    }

    /**
     * Get all ServiceCategory cases that belong to this group.
     */
    public function categories(): array
    {
        return array_values(array_filter(
            ServiceCategory::cases(),
            fn (ServiceCategory $cat) => $cat->group() === $this
        ));
    }

    /**
     * Serialize the full hierarchy for Alpine.js consumption.
     */
    public static function hierarchy(): array
    {
        return array_map(fn (self $group) => [
            'value' => $group->value,
            'label' => $group->label(),
            'categories' => array_map(fn (ServiceCategory $cat) => [
                'value' => $cat->value,
                'label' => $cat->label(),
                'description' => $cat->description(),
            ], $group->categories()),
        ], self::cases());
    }
}
