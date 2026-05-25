<?php

namespace Database\Factories;

use App\Enums\ListingStatus;
use App\Enums\ServiceCategory;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    protected $model = Service::class;

    public function definition(): array
    {
        $category = fake()->randomElement(ServiceCategory::cases());

        $names = [
            'architect' => ['Residential Floor Plan Design', '3D Architectural Rendering', 'Building Plan Approval'],
            'civil_structural_engineer' => ['Structural Analysis Report', 'Foundation Design', 'Structural Assessment'],
            'building_services_engineer' => ['MEP Design Services', 'Building Services Consultation'],
            'surveyor' => ['Land Survey Services', 'Topographic Survey', 'Site Analysis Survey'],
            'quantity_surveyor' => ['Bill of Quantities', 'Cost Estimation Services', 'Project Valuation'],
            'interior_designer' => ['Living Room Interior Design', 'Office Space Design', 'Full Home Interior'],
            'construction_project_manager' => ['Construction Project Management', 'Project Supervision'],
            'site_manager' => ['Site Management Services', 'Construction Supervision'],
            'facility_manager' => ['Facility Management', 'Building Maintenance Coordination'],
            'hse_officer' => ['Health & Safety Assessment', 'Safety Compliance Audit'],
            'supply_chain_manager' => ['Material Procurement Management', 'Supply Chain Coordination'],
            'mason_bricklayer' => ['Block Laying Services', 'Brick Wall Construction', 'Stone Masonry'],
            'concrete_finisher' => ['Concrete Floor Finishing', 'Stamped Concrete Work'],
            'roofing' => ['Aluminum Roofing', 'Stone Coated Roofing', 'Roof Repair Service'],
            'carpentry_woodwork' => ['Kitchen Cabinet Making', 'Wardrobe Design', 'Door Frame Installation'],
            'welding_ironworks' => ['Gate Fabrication', 'Burglary Proof', 'Staircase Railing'],
            'labourer' => ['Construction Labour Services', 'Site Clearing Services'],
            'water_borehole' => ['Borehole Drilling', 'Water Treatment Plant', 'Borehole Maintenance'],
            'renovation' => ['Full House Renovation', 'Bathroom Renovation', 'Kitchen Remodeling'],
            'electrician' => ['House Wiring', 'Industrial Electrical Setup', 'Electrical Fault Repair'],
            'plumber' => ['Bathroom Plumbing', 'Water Pipe Installation', 'Drainage Installation'],
            'hvac_installer' => ['AC Installation & Repair', 'Central Cooling System', 'Ventilation Setup'],
            'solar_energy_installer' => ['Solar Panel Installation', 'Solar Inverter Setup', 'Solar Maintenance'],
            'cable_tv_cctv_installer' => ['CCTV Camera Installation', 'DStv/GoTV Setup', 'Intercom Installation'],
            'ceiling_installer' => ['PVC Ceiling Installation', 'Suspended Ceiling', 'Ceiling Repair'],
            'generator_installer' => ['Generator Installation', 'ATS Setup', 'Generator Maintenance'],
            'painting' => ['Interior House Painting', 'Exterior Wall Painting', 'Texture Painting'],
            'plasterer' => ['Wall Plastering', 'Decorative Plasterwork', 'Skim Coat Application'],
            'screeder' => ['Floor Screeding', 'Self-Leveling Screed', 'Sand-Cement Screeding'],
            'pop_installer' => ['POP Ceiling Installation', 'POP Wall Design', 'POP Cornice Work'],
            'flooring_tiler' => ['Floor Tiling Services', 'Wall Tiling', 'Mosaic Tile Installation'],
            'hardwood_carpet_installer' => ['Hardwood Floor Installation', 'Carpet Fitting', 'Vinyl Flooring'],
            'window_installer' => ['Aluminum Window Installation', 'Sliding Window Setup', 'Window Replacement'],
            'door_installer' => ['Security Door Installation', 'Wooden Door Fitting', 'Glass Door Installation'],
            'fittings_finishing' => ['Bathroom Fittings', 'Kitchen Fittings', 'General Finishing Works'],
            'aluminium_glasswork' => ['Aluminium Partitioning', 'Glass Shower Enclosure', 'Shopfront Glazing'],
            'artist' => ['Mural Painting', 'Wall Art Design', 'Custom Art Commission'],
            'interior_decor' => ['Interior Decoration Services', 'Event Space Decoration', 'Home Styling'],
            'security_personnel' => ['Security Guard Service', 'Property Surveillance', 'Event Security'],
            'access_control_installer' => ['Biometric Access Control', 'Smart Lock Installation'],
            'fire_safety_installer' => ['Fire Alarm Installation', 'Fire Extinguisher Supply', 'Smoke Detector Setup'],
            'cleaning' => ['Deep Cleaning Service', 'Post-Construction Cleaning', 'Office Cleaning'],
            'cook' => ['Private Chef Service', 'Event Catering', 'Meal Prep Service'],
            'gardener' => ['Garden Maintenance', 'Landscape Design', 'Lawn Care Service'],
            'pest_control' => ['Fumigation Service', 'Termite Treatment', 'Rodent Control'],
            'general_services' => ['Handyman Service', 'Errand Running', 'Moving & Relocation'],
            'others' => ['Professional Service', 'Consultation Service', 'Custom Service'],
        ];

        $name = fake()->randomElement($names[$category->value] ?? ['Professional Service']);

        $priceFrom = fake()->randomElement([10000, 25000, 50000, 100000, 200000, 500000]);

        return [
            'user_id' => User::factory()->merchant(),
            'name' => $name,
            'description' => fake()->paragraphs(2, true),
            'category' => $category,
            'price_from' => $priceFrom,
            'price_to' => $priceFrom * fake()->randomElement([2, 3, 5]),
            'is_negotiable' => fake()->boolean(70),
            'listing_status' => ListingStatus::Active,
            'service_area' => fake()->randomElement(['Lagos', 'Lagos & Ogun', 'Nationwide', 'South-West Nigeria']),
            'highlights' => fake()->randomElements(['Fast delivery', 'Quality materials', 'Experienced team', 'Warranty included', '24/7 support'], 3),
            'is_featured' => fake()->boolean(20),
            'views_count' => fake()->numberBetween(0, 150),
        ];
    }
}
