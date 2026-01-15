<?php

return [
    // Resource labels
    'car_brand' => 'Car Brand',
    'car_brands' => 'Car Brands',
    'car_model' => 'Car Model',
    'car_models' => 'Car Models',
    'car_variant' => 'Variant',
    'car_variants' => 'Variants',
    'vehicle' => 'Vehicle',
    'vehicles' => 'Vehicles',

    // Navigation
    'navigation_group' => 'Automotive',

    // Common fields
    'name' => 'Name',
    'country' => 'Country',
    'logo' => 'Logo',
    'status' => 'Status',
    'active' => 'Active',
    'inactive' => 'Inactive',
    'created_at' => 'Created at',
    'updated_at' => 'Updated at',
    'not_specified' => 'Not specified',
    'present' => 'Present',

    // CarBrand fields
    'brand_name' => 'Brand Name',
    'brand_logo' => 'Logo',
    'brand_country' => 'Country of Origin',
    'models_count' => 'Number of Models',

    // CarBrand sections
    'brand_information' => 'Brand Information',
    'brand_information_desc' => 'Enter car brand details',

    // CarModel fields
    'model_name' => 'Model Name',
    'year_from' => 'Production Start Year',
    'year_to' => 'Production End Year',
    'year_range' => 'Production Years',
    'body_type' => 'Body Type',
    'variants_count' => 'Number of Variants',
    'vehicles_count' => 'Number of Vehicles',

    // CarModel sections
    'model_information' => 'Model Information',
    'model_information_desc' => 'Enter car model details',

    // CarVariant fields
    'variant_name' => 'Variant Name',
    'engine_code' => 'Engine Code',
    'engine_name' => 'Engine Name',
    'displacement' => 'Displacement',
    'displacement_cc' => 'Displacement (cc)',
    'power_kw' => 'Power (kW)',
    'power_hp' => 'Power (HP)',
    'torque_nm' => 'Torque (Nm)',
    'transmission' => 'Transmission',
    'doors' => 'Doors',

    // Enum: FuelType
    'fuel_type' => 'Fuel Type',
    'fuel_types' => [
        'petrol' => 'Petrol',
        'gasoline' => 'Gasoline',
        'diesel' => 'Diesel',
        'electric' => 'Electric',
        'hybrid' => 'Hybrid',
        'plugin_hybrid' => 'Plug-in Hybrid',
        'lpg' => 'LPG',
        'cng' => 'CNG',
        'hydrogen' => 'Hydrogen',
    ],

    // Enum: TransmissionType
    'transmission_types' => [
        'manual' => 'Manual',
        'automatic' => 'Automatic',
        'semi_automatic' => 'Semi-automatic',
        'cvt' => 'CVT',
    ],

    // Enum: BodyType
    'body_types' => [
        'hatchback' => 'Hatchback',
        'sedan' => 'Sedan',
        'wagon' => 'Station Wagon',
        'suv' => 'SUV',
        'crossover' => 'Crossover',
        'coupe' => 'Coupe',
        'convertible' => 'Convertible',
        'van' => 'Van',
        'pickup' => 'Pickup',
        'mpv' => 'MPV',
        'truck' => 'Truck',
    ],

    // Vehicle fields
    'customer' => 'Customer',
    'license_plate' => 'License Plate',
    'vin' => 'VIN Number',
    'color' => 'Color',
    'year' => 'Registration Year',
    'mileage' => 'Mileage',
    'engine' => 'Engine',
    'notes' => 'Notes',
    'is_active' => 'Active',
    'car_info' => 'Car',

    // Vehicle sections
    'vehicle_information' => 'Vehicle Information',
    'vehicle_identification' => 'Vehicle Identification',
    'vehicle_identification_desc' => 'Enter vehicle identification data',
    'technical_details' => 'Technical Details',
    'additional_information' => 'Additional Information',
    'customer_information' => 'Customer Information',
    'engine_information' => 'Engine Information',
    'production_years' => 'Production Years',

    // Actions
    'create_brand' => 'New Brand',
    'create_model' => 'New Model',
    'create_variant' => 'New Variant',
    'create_vehicle' => 'New Vehicle',
    'edit_brand' => 'Edit Brand',
    'edit_model' => 'Edit Model',
    'edit_variant' => 'Edit Variant',
    'edit_vehicle' => 'Edit Vehicle',
    'view_services' => 'View Services',
    'view_variants' => 'View Variants',

    // Filters
    'filter_status' => 'Filter by Status',
    'filter_brand' => 'Filter by Brand',
    'filter_body_type' => 'Filter by Body Type',
    'filter_fuel_type' => 'Filter by Fuel Type',
    'filter_customer' => 'Filter by Customer',

    // Messages
    'no_models' => 'No models available',
    'no_variants' => 'No variants available',
    'select_brand_first' => 'Select a brand first',
    'select_model_first' => 'Select a model first',
    'vehicle_has_services' => 'Cannot delete: vehicle has registered services',
    'brand_has_models' => 'Cannot delete: brand has associated models',
    'model_has_vehicles' => 'Cannot delete: model has associated vehicles',
    'model_has_variants' => 'Cannot delete: model has associated variants',
    'variant_has_vehicles' => 'Cannot delete: variant has associated vehicles',

    // Placeholders
    'select_brand' => 'Select a brand...',
    'select_model' => 'Select a model...',
    'select_variant' => 'Select a variant...',
    'select_fuel_type' => 'Select fuel type...',
    'select_transmission' => 'Select transmission...',
    'select_body_type' => 'Select body type...',
    'vin_placeholder' => 'E.g. WVWZZZ3CZWE123456',
    'engine_placeholder' => 'E.g. 1.6 TDI 115 HP',
    'notes_placeholder' => 'Additional notes about the vehicle...',

    // Helper text
    'is_active_help' => 'Inactive vehicles will not appear in selections',
];
