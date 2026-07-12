<?php

namespace App\Enums;

enum ProductSubCategory: string
{
    // Electricals
    case WiringCables = 'wiring_cables';
    case SwitchesSockets = 'switches_sockets';
    case CircuitBreakers = 'circuit_breakers';
    case Transformers = 'transformers';
    case GeneratorsInverters = 'generators_inverters';

    // Electronics
    case PhonesTablets = 'phones_tablets';
    case LaptopsComputers = 'laptops_computers';
    case TVsMonitors = 'tvs_monitors';
    case AudioSpeakers = 'audio_speakers';
    case SmartHomeDevices = 'smart_home_devices';

    // Building Materials
    case CementConcrete = 'cement_concrete';
    case BlocksBricks = 'blocks_bricks';
    case RoofingMaterials = 'roofing_materials';
    case SteelIron = 'steel_iron';
    case SandGravel = 'sand_gravel';

    // Sanitary Ware
    case ToiletsWCs = 'toilets_wcs';
    case SinksBasins = 'sinks_basins';
    case BathtubsShowers = 'bathtubs_showers';
    case FaucetsTaps = 'faucets_taps';
    case PipesFittings = 'pipes_fittings';

    // Furniture
    case LivingRoom = 'living_room';
    case Bedroom = 'bedroom';
    case Office = 'office';
    case KitchenDining = 'kitchen_dining';
    case Outdoor = 'outdoor';

    // Cooling Systems
    case AirConditioners = 'air_conditioners';
    case Fans = 'fans';
    case Refrigerators = 'refrigerators';
    case Freezers = 'freezers';
    case Coolers = 'coolers';

    // Windows
    case AluminiumWindows = 'aluminium_windows';
    case GlassWindows = 'glass_windows';
    case WoodenWindows = 'wooden_windows';
    case WindowFrames = 'window_frames';
    case BurglarProof = 'burglar_proof';

    // Curtains
    case LivingRoomCurtains = 'living_room_curtains';
    case BedroomCurtains = 'bedroom_curtains';
    case OfficeCurtains = 'office_curtains';
    case ShowerCurtains = 'shower_curtains';
    case CurtainAccessories = 'curtain_accessories';

    // Window Blinds
    case RollerBlinds = 'roller_blinds';
    case VenetianBlinds = 'venetian_blinds';
    case VerticalBlinds = 'vertical_blinds';
    case WoodenBlinds = 'wooden_blinds';
    case DayNightBlinds = 'day_night_blinds';

    // Interior Decor
    case WallArtPaintings = 'wall_art_paintings';
    case LightingLamps = 'lighting_lamps';
    case RugsCarpets = 'rugs_carpets';
    case Mirrors = 'mirrors';
    case PlantsVases = 'plants_vases';

    public function label(): string
    {
        return match ($this) {
            // Electricals
            self::WiringCables => 'Wiring & Cables',
            self::SwitchesSockets => 'Switches & Sockets',
            self::CircuitBreakers => 'Circuit Breakers',
            self::Transformers => 'Transformers',
            self::GeneratorsInverters => 'Generators & Inverters',

            // Electronics
            self::PhonesTablets => 'Phones & Tablets',
            self::LaptopsComputers => 'Laptops & Computers',
            self::TVsMonitors => 'TVs & Monitors',
            self::AudioSpeakers => 'Audio & Speakers',
            self::SmartHomeDevices => 'Smart Home Devices',

            // Building Materials
            self::CementConcrete => 'Cement & Concrete',
            self::BlocksBricks => 'Blocks & Bricks',
            self::RoofingMaterials => 'Roofing Materials',
            self::SteelIron => 'Steel & Iron',
            self::SandGravel => 'Sand & Gravel',

            // Sanitary Ware
            self::ToiletsWCs => 'Toilets & WCs',
            self::SinksBasins => 'Sinks & Basins',
            self::BathtubsShowers => 'Bathtubs & Showers',
            self::FaucetsTaps => 'Faucets & Taps',
            self::PipesFittings => 'Pipes & Fittings',

            // Furniture
            self::LivingRoom => 'Living Room',
            self::Bedroom => 'Bedroom',
            self::Office => 'Office',
            self::KitchenDining => 'Kitchen & Dining',
            self::Outdoor => 'Outdoor',

            // Cooling Systems
            self::AirConditioners => 'Air Conditioners',
            self::Fans => 'Fans',
            self::Refrigerators => 'Refrigerators',
            self::Freezers => 'Freezers',
            self::Coolers => 'Coolers',

            // Windows
            self::AluminiumWindows => 'Aluminium Windows',
            self::GlassWindows => 'Glass Windows',
            self::WoodenWindows => 'Wooden Windows',
            self::WindowFrames => 'Window Frames',
            self::BurglarProof => 'Burglar Proof',

            // Curtains
            self::LivingRoomCurtains => 'Living Room Curtains',
            self::BedroomCurtains => 'Bedroom Curtains',
            self::OfficeCurtains => 'Office Curtains',
            self::ShowerCurtains => 'Shower Curtains',
            self::CurtainAccessories => 'Curtain Accessories',

            // Window Blinds
            self::RollerBlinds => 'Roller Blinds',
            self::VenetianBlinds => 'Venetian Blinds',
            self::VerticalBlinds => 'Vertical Blinds',
            self::WoodenBlinds => 'Wooden Blinds',
            self::DayNightBlinds => 'Day & Night Blinds',

            // Interior Decor
            self::WallArtPaintings => 'Wall Art & Paintings',
            self::LightingLamps => 'Lighting & Lamps',
            self::RugsCarpets => 'Rugs & Carpets',
            self::Mirrors => 'Mirrors',
            self::PlantsVases => 'Plants & Vases',
        };
    }

    public function parentCategory(): ProductCategory
    {
        return match ($this) {
            self::WiringCables, self::SwitchesSockets, self::CircuitBreakers,
            self::Transformers, self::GeneratorsInverters => ProductCategory::Electricals,

            self::PhonesTablets, self::LaptopsComputers, self::TVsMonitors,
            self::AudioSpeakers, self::SmartHomeDevices => ProductCategory::Electronics,

            self::CementConcrete, self::BlocksBricks, self::RoofingMaterials,
            self::SteelIron, self::SandGravel => ProductCategory::BuildingMaterials,

            self::ToiletsWCs, self::SinksBasins, self::BathtubsShowers,
            self::FaucetsTaps, self::PipesFittings => ProductCategory::SanitaryWare,

            self::LivingRoom, self::Bedroom, self::Office,
            self::KitchenDining, self::Outdoor => ProductCategory::Furniture,

            self::AirConditioners, self::Fans, self::Refrigerators,
            self::Freezers, self::Coolers => ProductCategory::CoolingSystems,

            self::AluminiumWindows, self::GlassWindows, self::WoodenWindows,
            self::WindowFrames, self::BurglarProof => ProductCategory::Windows,

            self::LivingRoomCurtains, self::BedroomCurtains, self::OfficeCurtains,
            self::ShowerCurtains, self::CurtainAccessories => ProductCategory::Curtains,

            self::RollerBlinds, self::VenetianBlinds, self::VerticalBlinds,
            self::WoodenBlinds, self::DayNightBlinds => ProductCategory::WindowBlinds,

            self::WallArtPaintings, self::LightingLamps, self::RugsCarpets,
            self::Mirrors, self::PlantsVases => ProductCategory::InteriorDecor,
        };
    }

    /**
     * Get all sub-categories for a given parent category.
     */
    public static function forCategory(ProductCategory $category): array
    {
        return array_values(array_filter(self::cases(), fn (self $sub) => $sub->parentCategory() === $category));
    }
}
