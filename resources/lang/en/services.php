<?php

return [
    // ============================================
    // DIAGNOSIS RESOURCE
    // ============================================
    'diagnosis' => [
        'singular' => 'Diagnosis',
        'plural' => 'Diagnoses',
        'vehicle_customer_info' => 'Vehicle & Customer',
        'vehicle_customer_info_desc' => 'Vehicle and owner information',
        'acceptance_date' => 'Acceptance Date',
        'mileage_at_acceptance' => 'Mileage at Acceptance',
        'diagnosis_info' => 'Diagnosis Information',
        'customer_complaint' => 'Customer Complaint',
        'customer_complaint_placeholder' => 'Describe the customer\'s complaint...',
        'initial_diagnosis' => 'Initial Diagnosis',
        'initial_diagnosis_placeholder' => 'Enter the preliminary diagnosis...',
        'status' => 'Status',
        'notes' => 'Notes',
        'notes_placeholder' => 'Additional notes...',
        'service_records_count' => 'Service Records',
    ],

    // Diagnosis statuses
    'diagnosis_statuses' => [
        'draft' => 'Draft',
        'open' => 'Open',
        'closed' => 'Closed',
    ],

    // ============================================
    // DASHBOARD
    // ============================================
    'dashboard' => [
        'open_diagnoses' => 'Open Diagnoses',
        'waiting_evaluation' => 'Waiting for evaluation',
        'in_progress' => 'In Progress',
        'services_in_progress' => 'Services in progress',
        'scheduled' => 'Scheduled',
        'waiting_to_start' => 'Waiting to start',
        'completed_month' => 'Completed',
        'this_month' => 'This month',
        'total_vehicles' => 'Total Vehicles',
        'registered_vehicles' => 'Registered vehicles',
        'quick_actions' => 'Quick Actions',
        'new_diagnosis' => 'New Diagnosis',
        'new_vehicle' => 'New Vehicle',
    ],

    // ============================================
    // SERVICE RECORD RESOURCE
    // ============================================
    // Resource labels
    'service_record' => 'Service Record',
    'service_records' => 'Service Records',
    'service_line' => 'Service Line',
    'service_lines' => 'Service Lines',

    // Navigation
    'navigation_group' => 'Automotive',

    // Common fields
    'created_at' => 'Created at',
    'updated_at' => 'Updated at',
    'not_specified' => 'Not specified',
    'days' => 'days',

    // Service types
    'types' => [
        'mechanics' => 'Mechanics',
        'mechanics_plural' => 'Mechanics Services',
        'bodywork' => 'Bodywork',
        'bodywork_plural' => 'Bodywork Services',
        'tires' => 'Tires',
        'tires_plural' => 'Tire Services',
        'electrician' => 'Auto Electrician',
        'electrician_plural' => 'Electrician Services',
    ],

    // ServiceRecord fields
    'vehicle' => 'Vehicle',
    'customer' => 'Customer',
    'service_date' => 'Service Date',
    'mileage_at_service' => 'Mileage',
    'mileage' => 'Mileage',
    'status' => 'Status',
    'statuses' => [
        'draft' => 'Draft',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],
    'customer_complaint' => 'Customer Complaint',
    'diagnosis' => 'Diagnosis',
    'notes' => 'Notes',
    'total_amount' => 'Total',

    // ServiceRecordLine fields
    'line_type' => 'Type',
    'line_types' => [
        'labor' => 'Labor',
        'part' => 'Part',
        'other' => 'Other',
    ],
    'description' => 'Description',
    'quantity' => 'Quantity',
    'unit_price' => 'Unit Price',
    'line_total' => 'Line Total',
    'part' => 'Part',
    'add_part' => 'Add Part',
    'note' => 'Note',

    // Sections
    'service_information' => 'Service Information',
    'service_information_desc' => 'Enter service record details',
    'service_details' => 'Service Details',
    'problem_and_diagnosis' => 'Problem and Diagnosis',
    'financial_summary' => 'Financial Summary',
    'lines' => 'Service Lines',

    // Placeholders
    'customer_complaint_placeholder' => 'Describe the customer\'s complaint...',
    'diagnosis_placeholder' => 'Enter the technician\'s diagnosis...',
    'notes_placeholder' => 'Additional notes about the service...',

    // Helper text
    'total_amount_help' => 'Automatically calculated from service lines',

    // Actions
    'create_service' => 'New Service',
    'edit_service' => 'Edit Service',
    'add_line' => 'Add Line',
    'complete_service' => 'Complete Service',
    'cancel_service' => 'Cancel Service',

    // Filters
    'filter_status' => 'Filter by Status',
    'filter_vehicle' => 'Filter by Vehicle',
    'filter_customer' => 'Filter by Customer',

    // Messages
    'cannot_edit_completed' => 'Cannot edit a completed service',
    'cannot_delete_completed' => 'Cannot delete a completed service',
    'only_draft_deletable' => 'Only draft services can be deleted',
    'vehicle_required' => 'Select a vehicle',
    'customer_auto_filled' => 'Customer auto-filled from vehicle',

    // Summary
    'total_labor' => 'Total Labor',
    'total_parts' => 'Total Parts',
    'total_other' => 'Total Other',
    'grand_total' => 'Grand Total',

    // Settings
    'settings' => [
        'heading' => 'Services Settings',
        'navigation_label' => 'Services',
        'service_types' => [
            'title' => 'Service Types',
            'description' => 'Enable or disable specific service types for your business',
            'mechanics' => 'Mechanics',
            'mechanics_help' => 'General vehicle maintenance and repairs',
            'bodywork' => 'Bodywork',
            'bodywork_help' => 'Body repairs, painting, and collision work',
            'tires' => 'Tires',
            'tires_help' => 'Tire installation, balancing, and rotation',
            'electrician' => 'Auto Electrician',
            'electrician_help' => 'Electrical systems, diagnostics, and repairs',
        ],
    ],

    // ============================================
    // MECHANICS SERVICE TYPE
    // ============================================
    'mechanics' => [
        'parameters' => 'Mechanics Parameters',
        'parameters_desc' => 'Specific details for mechanics services',
        'labor_hours' => 'Labor Hours',
        'work_type' => 'Work Type',
        'work_types' => [
            'maintenance' => 'Routine Maintenance',
            'repair' => 'Repair',
            'inspection' => 'Inspection',
            'overhaul' => 'Overhaul',
        ],
        'diagnosis' => 'Diagnosis',
        'diagnosis_placeholder' => 'Enter the diagnosis...',
        'work_performed' => 'Work Performed',
        'work_performed_placeholder' => 'Describe the work done...',
        'parts_replaced' => 'Parts Replaced',
        'part_name' => 'Part Name',
        'part_quantity' => 'Quantity',
        'add_part' => 'Add Part',
        'search_part' => 'Search part by brand or model...',
    ],

    // ============================================
    // BODYWORK SERVICE TYPE
    // ============================================
    'bodywork' => [
        'parameters' => 'Bodywork Parameters',
        'parameters_desc' => 'Specific details for bodywork services',
        'damage_areas' => 'Damaged Areas',
        'areas' => [
            'front_bumper' => 'Front Bumper',
            'rear_bumper' => 'Rear Bumper',
            'hood' => 'Hood',
            'trunk' => 'Trunk',
            'roof' => 'Roof',
            'left_front_door' => 'Left Front Door',
            'left_rear_door' => 'Left Rear Door',
            'right_front_door' => 'Right Front Door',
            'right_rear_door' => 'Right Rear Door',
            'left_fender' => 'Left Fender',
            'right_fender' => 'Right Fender',
            'left_quarter_panel' => 'Left Quarter Panel',
            'right_quarter_panel' => 'Right Quarter Panel',
        ],
        'repair_type' => 'Repair Type',
        'repair_types' => [
            'dent_repair' => 'Dent Repair',
            'scratch_repair' => 'Scratch Repair',
            'partial_repaint' => 'Partial Repaint',
            'full_repaint' => 'Full Repaint',
            'panel_replacement' => 'Panel Replacement',
        ],
        'paint_type' => 'Paint Type',
        'paint_types' => [
            'solid' => 'Solid',
            'metallic' => 'Metallic',
            'pearl' => 'Pearl',
            'matte' => 'Matte',
        ],
        'paint_code' => 'Paint Code',
        'estimated_days' => 'Estimated Days',
        'insurance_claim' => 'Insurance Claim',
        'insurance_claim_placeholder' => 'Insurance claim number...',
        'damage_description' => 'Damage Description',
        'parts_used' => 'Parts Used',
        'search_part' => 'Search part by brand or model...',
    ],

    // ============================================
    // TIRE SERVICE TYPE
    // ============================================
    'tires' => [
        'parameters' => 'Tire Parameters',
        'parameters_desc' => 'Specific details for tire services',
        'is_two_wheeler' => 'Two-Wheeler Vehicle',
        'is_two_wheeler_help' => 'Enable for motorcycles, scooters, or mopeds',
        'service_type' => 'Service Type',
        'service_types' => [
            'replacement' => 'Replacement',
            'rotation' => 'Rotation',
            'balancing' => 'Balancing',
            'alignment' => 'Alignment',
            'repair' => 'Repair',
            'seasonal_change' => 'Seasonal Change',
        ],
        'tire_season' => 'Tire Season',
        'seasons' => [
            'summer' => 'Summer',
            'winter' => 'Winter',
            'all_season' => 'All Season',
        ],
        'positions_label' => 'Positions',
        'position' => 'Position',
        'positions' => [
            'front_left' => 'Front Left',
            'front_right' => 'Front Right',
            'rear_left' => 'Rear Left',
            'rear_right' => 'Rear Right',
            'front' => 'Front',
            'rear' => 'Rear',
        ],
        'tire_details' => 'Tire Details',
        'brand' => 'Brand',
        'model' => 'Model',
        'size' => 'Size',
        'size_help' => 'Format: width/height R diameter (e.g. 225/45R17)',
        'load_index' => 'Load Index',
        'speed_index' => 'Speed Index',
        'dot' => 'DOT (Week/Year)',
        'dot_help' => 'Last 4 digits indicate week and year of manufacture',
        'tread_depth' => 'Tread Depth',
        'load_speed' => 'Load/Speed Index',
        'tire_product' => 'Tire',
        'search_tire' => 'Search by brand or model...',
        'store_old_tires' => 'Store Old Tires',
        'store_old_tires_help' => 'Enable if customer stores tires with you',
        'storage_location' => 'Storage Location',
        'storage_location_placeholder' => 'e.g. Shelf A3, Box 15...',
    ],

    // ============================================
    // ELECTRICIAN SERVICE TYPE
    // ============================================
    'electrician' => [
        'parameters' => 'Electrician Parameters',
        'parameters_desc' => 'Specific details for electrical services',
        'system_area' => 'System Area',
        'areas' => [
            'engine_management' => 'Engine Management',
            'starting_system' => 'Starting System',
            'charging_system' => 'Charging System',
            'lighting' => 'Lighting',
            'sensors' => 'Sensors',
            'infotainment' => 'Infotainment',
            'climate_control' => 'Climate Control',
            'safety_systems' => 'Safety Systems',
            'wiring' => 'Wiring',
            'other' => 'Other',
        ],
        'service_type' => 'Service Type',
        'service_types' => [
            'diagnosis' => 'Diagnosis',
            'repair' => 'Repair',
            'replacement' => 'Replacement',
            'installation' => 'Installation',
            'programming' => 'Programming',
        ],
        'diagnostic_codes' => 'Diagnostic Codes',
        'diagnostic_codes_placeholder' => 'e.g. P0300, P0171, B1234...',
        'diagnostic_codes_help' => 'Enter OBD error codes detected (one per line)',
        'components_tested' => 'Components Tested',
        'components' => [
            'battery' => 'Battery',
            'alternator' => 'Alternator',
            'starter' => 'Starter Motor',
            'fuses' => 'Fuses',
            'relays' => 'Relays',
            'wiring_harness' => 'Wiring Harness',
            'ecu' => 'ECU (Engine Control Unit)',
            'sensors' => 'Sensors',
            'actuators' => 'Actuators',
        ],
        'battery_status' => 'Battery Status',
        'battery_voltage' => 'Battery Voltage',
        'battery_cca' => 'CCA (Cold Cranking Amps)',
        'battery_cca_help' => 'Cold Cranking Amps rating',
        'battery_health' => 'Health Status',
        'battery_condition' => 'Condition',
        'conditions' => [
            'good' => 'Good',
            'fair' => 'Fair',
            'weak' => 'Weak',
            'replace' => 'Needs Replacement',
        ],
        'firmware_update_required' => 'Firmware Update Required',
        'firmware_update_help' => 'ECU needs software update',
        'work_performed' => 'Work Performed',
        'parts_used' => 'Parts Used',
        'search_part' => 'Search part by brand or model...',
    ],
];
