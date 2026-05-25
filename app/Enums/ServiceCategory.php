<?php

namespace App\Enums;

enum ServiceCategory: string
{
    // --- Design & Planning ---
    case Architect = 'architect';
    case CivilStructuralEngineer = 'civil_structural_engineer';
    case BuildingServicesEngineer = 'building_services_engineer';
    case Surveyor = 'surveyor';
    case QuantitySurveyor = 'quantity_surveyor';
    case InteriorDesigner = 'interior_designer';

    // --- Project & Site Management ---
    case ConstructionProjectManager = 'construction_project_manager';
    case SiteManager = 'site_manager';
    case FacilityManager = 'facility_manager';
    case HSEOfficer = 'hse_officer';
    case SupplyChainManager = 'supply_chain_manager';

    // --- Structural & Construction Works ---
    case MasonBricklayer = 'mason_bricklayer';
    case ConcreteFinisher = 'concrete_finisher';
    case Roofing = 'roofing';
    case CarpentryWoodwork = 'carpentry_woodwork';
    case WeldingIronworks = 'welding_ironworks';
    case Labourer = 'labourer';
    case WaterBorehole = 'water_borehole';
    case Renovation = 'renovation';

    // --- Electrical, Mechanical & Technical Installations ---
    case Electrician = 'electrician';
    case Plumber = 'plumber';
    case HVACInstaller = 'hvac_installer';
    case SolarEnergyInstaller = 'solar_energy_installer';
    case CableTVCCTVInstaller = 'cable_tv_cctv_installer';
    case CeilingInstaller = 'ceiling_installer';
    case GeneratorInstaller = 'generator_installer';

    // --- Finishing & Interior Works ---
    case Painting = 'painting';
    case Plasterer = 'plasterer';
    case Screeder = 'screeder';
    case POPInstaller = 'pop_installer';
    case FlooringTiler = 'flooring_tiler';
    case HardwoodCarpetInstaller = 'hardwood_carpet_installer';
    case WindowInstaller = 'window_installer';
    case DoorInstaller = 'door_installer';
    case FittingsFinishing = 'fittings_finishing';
    case AluminiumGlasswork = 'aluminium_glasswork';
    case Artist = 'artist';
    case InteriorDecor = 'interior_decor';

    // --- Security & Safety Services ---
    case SecurityPersonnel = 'security_personnel';
    case AccessControlInstaller = 'access_control_installer';
    case FireSafetyInstaller = 'fire_safety_installer';

    // --- Household & Domestic Services ---
    case Cleaning = 'cleaning';
    case Cook = 'cook';
    case Gardener = 'gardener';
    case PestControl = 'pest_control';
    case GeneralServices = 'general_services';
    case Others = 'others';

    public function label(): string
    {
        return match ($this) {
            // Design & Planning
            self::Architect => 'Architect',
            self::CivilStructuralEngineer => 'Civil / Structural Engineer',
            self::BuildingServicesEngineer => 'Building Services Engineer',
            self::Surveyor => 'Surveyor',
            self::QuantitySurveyor => 'Quantity Surveyor',
            self::InteriorDesigner => 'Interior Designer',

            // Project & Site Management
            self::ConstructionProjectManager => 'Construction Project Manager',
            self::SiteManager => 'Site Manager / Site Engineer',
            self::FacilityManager => 'Facility Manager',
            self::HSEOfficer => 'HSE Officer',
            self::SupplyChainManager => 'Supply Chain Manager',

            // Structural & Construction Works
            self::MasonBricklayer => 'Mason / Bricklayer',
            self::ConcreteFinisher => 'Concrete Finisher',
            self::Roofing => 'Roofer',
            self::CarpentryWoodwork => 'Carpenter / Joiner / Furniture Maker',
            self::WeldingIronworks => 'Welder / Ironworker',
            self::Labourer => 'Labourer',
            self::WaterBorehole => 'Water Borehole',
            self::Renovation => 'Renovation',

            // Electrical, Mechanical & Technical
            self::Electrician => 'Electrician',
            self::Plumber => 'Plumber',
            self::HVACInstaller => 'Warming & Cooling Unit Installer',
            self::SolarEnergyInstaller => 'Solar Energy Installer',
            self::CableTVCCTVInstaller => 'Cable TV & CCTV Installer',
            self::CeilingInstaller => 'Ceiling Installer',
            self::GeneratorInstaller => 'Generator Installer',

            // Finishing & Interior Works
            self::Painting => 'Painter',
            self::Plasterer => 'Plasterer',
            self::Screeder => 'Screeder',
            self::POPInstaller => 'POP Installer',
            self::FlooringTiler => 'Flooring Installer / Tiler',
            self::HardwoodCarpetInstaller => 'Hardwood & Carpet Installer',
            self::WindowInstaller => 'Window Installer',
            self::DoorInstaller => 'Door Installer',
            self::FittingsFinishing => 'Fittings & Finishing',
            self::AluminiumGlasswork => 'Aluminium & Glasswork',
            self::Artist => 'Artist',
            self::InteriorDecor => 'Interior Decor Services',

            // Security & Safety
            self::SecurityPersonnel => 'Security Personnel',
            self::AccessControlInstaller => 'Access Control Installer',
            self::FireSafetyInstaller => 'Fire Safety Installer',

            // Household & Domestic
            self::Cleaning => 'Cleaner',
            self::Cook => 'Cook',
            self::Gardener => 'Gardener',
            self::PestControl => 'Pest Control',
            self::GeneralServices => 'General Services',
            self::Others => 'Others',
        };
    }

    public function description(): string
    {
        return match ($this) {
            // Design & Planning
            self::Architect => 'Professional architectural design services including floor plans, 3D renderings, building plan approvals, and construction drawings for residential and commercial projects.',
            self::CivilStructuralEngineer => 'Structural analysis, foundation design, and engineering reports for buildings and infrastructure. Ensures structural integrity and compliance with building codes.',
            self::BuildingServicesEngineer => 'Mechanical, electrical, and plumbing (MEP) design services for buildings. Covers HVAC, lighting, fire protection, and water supply systems.',
            self::Surveyor => 'Land and topographic survey services including boundary demarcation, site analysis, and mapping for construction and property transactions.',
            self::QuantitySurveyor => 'Cost estimation, bill of quantities preparation, project valuation, and cost management services for construction projects.',
            self::InteriorDesigner => 'Creative interior design solutions for homes, offices, and commercial spaces. Includes space planning, material selection, and design concepts.',

            // Project & Site Management
            self::ConstructionProjectManager => 'End-to-end construction project management including planning, scheduling, budgeting, quality control, and stakeholder coordination.',
            self::SiteManager => 'On-site construction supervision and management ensuring work quality, safety compliance, and timely project delivery.',
            self::FacilityManager => 'Building and facility maintenance coordination, operations management, and ensuring optimal functioning of building systems.',
            self::HSEOfficer => 'Health, safety, and environmental compliance services including risk assessments, safety audits, and workplace safety training.',
            self::SupplyChainManager => 'Construction material procurement, logistics coordination, vendor management, and supply chain optimization for building projects.',

            // Structural & Construction Works
            self::MasonBricklayer => 'Block laying, brick wall construction, and stone masonry services for residential and commercial buildings.',
            self::ConcreteFinisher => 'Concrete floor finishing, stamped concrete, polished concrete, and decorative concrete work for floors and surfaces.',
            self::Roofing => 'Roof installation and repair services including aluminium roofing, stone-coated tiles, long-span roofing, and waterproofing.',
            self::CarpentryWoodwork => 'Custom carpentry services including kitchen cabinets, wardrobes, door frames, furniture making, and wood finishing.',
            self::WeldingIronworks => 'Metal fabrication services including gate design, burglary proofing, staircase railings, window protectors, and structural steel work.',
            self::Labourer => 'General construction labour services including site clearing, material handling, excavation, and manual construction tasks.',
            self::WaterBorehole => 'Borehole drilling, water treatment plant installation, pump fitting, and borehole maintenance and rehabilitation services.',
            self::Renovation => 'Full and partial renovation services for homes and commercial properties including structural repairs, upgrades, and remodeling.',

            // Electrical, Mechanical & Technical
            self::Electrician => 'Electrical wiring, panel installation, fault diagnosis and repair, lighting setup, and industrial electrical services.',
            self::Plumber => 'Plumbing installation and repair services including water pipes, drainage systems, bathroom fittings, and water heater installation.',
            self::HVACInstaller => 'Air conditioning installation and repair, central cooling systems, ventilation setup, and climate control solutions.',
            self::SolarEnergyInstaller => 'Solar panel installation, inverter setup, battery systems, and solar energy maintenance for homes and businesses.',
            self::CableTVCCTVInstaller => 'CCTV security camera installation, satellite TV setup (DStv/GOtv), intercom systems, and networking solutions.',
            self::CeilingInstaller => 'PVC ceiling, suspended ceiling, and acoustic ceiling installation, repair, and replacement services.',
            self::GeneratorInstaller => 'Generator installation, automatic transfer switch (ATS) setup, generator servicing, and power backup solutions.',

            // Finishing & Interior Works
            self::Painting => 'Interior and exterior painting services including texture painting, wall art, spray painting, and protective coatings.',
            self::Plasterer => 'Wall and ceiling plastering, decorative plasterwork, skim coat application, and rendering services.',
            self::Screeder => 'Floor screeding services including sand-cement screeding, self-leveling screed, and floor preparation for tiling.',
            self::POPInstaller => 'Plaster of Paris (POP) ceiling installation, wall moulding, cornice work, and decorative POP designs.',
            self::FlooringTiler => 'Floor and wall tiling services using ceramic, porcelain, granite, marble, and mosaic tiles for all spaces.',
            self::HardwoodCarpetInstaller => 'Hardwood floor, laminate, vinyl, and carpet installation, fitting, and restoration services.',
            self::WindowInstaller => 'Window installation and replacement including aluminium, casement, sliding, and glass window systems.',
            self::DoorInstaller => 'Door installation services including security doors, wooden doors, glass doors, and automatic door systems.',
            self::FittingsFinishing => 'General finishing works including bathroom fittings, kitchen fittings, fixture mounting, and final touch-up services.',
            self::AluminiumGlasswork => 'Aluminium partitioning, glass shower enclosures, shopfront glazing, curtain walls, and aluminium cladding.',
            self::Artist => 'Mural painting, wall art design, custom art commissions, and decorative art installations for homes and businesses.',
            self::InteriorDecor => 'Interior decoration services including furniture arrangement, colour coordination, window treatments, and space styling.',

            // Security & Safety
            self::SecurityPersonnel => 'Trained security guard services for properties, estates, events, and commercial premises with 24/7 coverage.',
            self::AccessControlInstaller => 'Biometric access control, smart lock installation, keypad entry systems, and gate automation services.',
            self::FireSafetyInstaller => 'Fire alarm systems, smoke detectors, fire extinguisher supply and installation, and fire safety compliance services.',

            // Household & Domestic
            self::Cleaning => 'Professional cleaning services including deep cleaning, post-construction cleaning, office cleaning, and regular maintenance.',
            self::Cook => 'Private chef services, event catering, meal preparation, and professional cooking services for homes and events.',
            self::Gardener => 'Garden maintenance, landscape design, lawn care, tree trimming, and outdoor space beautification services.',
            self::PestControl => 'Pest control services including fumigation, termite treatment, rodent control, and insect extermination.',
            self::GeneralServices => 'Handyman services, errand running, moving and relocation, and general maintenance tasks.',
            self::Others => 'Professional services not covered by other categories. Please describe your service in detail.',
        };
    }

    public function group(): ServiceGroup
    {
        return match ($this) {
            self::Architect,
            self::CivilStructuralEngineer,
            self::BuildingServicesEngineer,
            self::Surveyor,
            self::QuantitySurveyor,
            self::InteriorDesigner => ServiceGroup::DesignPlanning,

            self::ConstructionProjectManager,
            self::SiteManager,
            self::FacilityManager,
            self::HSEOfficer,
            self::SupplyChainManager => ServiceGroup::ProjectSiteManagement,

            self::MasonBricklayer,
            self::ConcreteFinisher,
            self::Roofing,
            self::CarpentryWoodwork,
            self::WeldingIronworks,
            self::Labourer,
            self::WaterBorehole,
            self::Renovation => ServiceGroup::StructuralConstruction,

            self::Electrician,
            self::Plumber,
            self::HVACInstaller,
            self::SolarEnergyInstaller,
            self::CableTVCCTVInstaller,
            self::CeilingInstaller,
            self::GeneratorInstaller => ServiceGroup::ElectricalMechanical,

            self::Painting,
            self::Plasterer,
            self::Screeder,
            self::POPInstaller,
            self::FlooringTiler,
            self::HardwoodCarpetInstaller,
            self::WindowInstaller,
            self::DoorInstaller,
            self::FittingsFinishing,
            self::AluminiumGlasswork,
            self::Artist,
            self::InteriorDecor => ServiceGroup::FinishingInterior,

            self::SecurityPersonnel,
            self::AccessControlInstaller,
            self::FireSafetyInstaller => ServiceGroup::SecuritySafety,

            self::Cleaning,
            self::Cook,
            self::Gardener,
            self::PestControl,
            self::GeneralServices,
            self::Others => ServiceGroup::HouseholdDomestic,
        };
    }
}
