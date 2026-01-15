<?php

/**
 * Services Module Permissions
 *
 * These permissions are automatically installed when the module is enabled
 * and removed when the module is disabled.
 *
 * Resources:
 * - ServiceRecord: Manage vehicle service and repair records
 * - CarBrand: Manage car manufacturers and brands
 * - CarModel: Manage car models for each brand
 * - Vehicle: Manage customer vehicles and fleet
 * - MechanicsService: Manage mechanics service records
 * - BodyworkService: Manage bodywork service records
 * - TireService: Manage tire service records
 * - ElectricianService: Manage electrician service records
 */

return [
    // ServiceRecord CRUD (legacy/generic)
    [
        'name' => 'Manage service records',
        'code' => 'manage-service-records',
        'namespace' => 'services',
        'resource' => 'service-records',
        'action' => 'manage',
        'description' => 'Full CRUD access to vehicle service and repair records',
    ],

    // CarBrand CRUD
    [
        'name' => 'Manage car brands',
        'code' => 'manage-car-brands',
        'namespace' => 'services',
        'resource' => 'car-brands',
        'action' => 'manage',
        'description' => 'Full CRUD access to car brands and manufacturers',
    ],

    // CarModel CRUD
    [
        'name' => 'Manage car models',
        'code' => 'manage-car-models',
        'namespace' => 'services',
        'resource' => 'car-models',
        'action' => 'manage',
        'description' => 'Full CRUD access to car models',
    ],

    // Vehicle CRUD
    [
        'name' => 'Manage vehicles',
        'code' => 'manage-vehicles',
        'namespace' => 'services',
        'resource' => 'vehicles',
        'action' => 'manage',
        'description' => 'Full CRUD access to customer vehicles and fleet',
    ],

    // Diagnosis CRUD
    [
        'name' => 'Manage diagnoses',
        'code' => 'manage-diagnoses',
        'namespace' => 'services',
        'resource' => 'diagnoses',
        'action' => 'manage',
        'description' => 'Full CRUD access to vehicle diagnoses and acceptance records',
    ],

    // ============================================
    // SERVICE TYPE RESOURCES
    // ============================================

    // Mechanics Service CRUD
    [
        'name' => 'Manage mechanics services',
        'code' => 'manage-mechanics-services',
        'namespace' => 'services',
        'resource' => 'mechanics-services',
        'action' => 'manage',
        'description' => 'Full CRUD access to mechanics service records',
    ],

    // Bodywork Service CRUD
    [
        'name' => 'Manage bodywork services',
        'code' => 'manage-bodywork-services',
        'namespace' => 'services',
        'resource' => 'bodywork-services',
        'action' => 'manage',
        'description' => 'Full CRUD access to bodywork service records',
    ],

    // Tire Service CRUD
    [
        'name' => 'Manage tire services',
        'code' => 'manage-tire-services',
        'namespace' => 'services',
        'resource' => 'tire-services',
        'action' => 'manage',
        'description' => 'Full CRUD access to tire service records',
    ],

    // Electrician Service CRUD
    [
        'name' => 'Manage electrician services',
        'code' => 'manage-electrician-services',
        'namespace' => 'services',
        'resource' => 'electrician-services',
        'action' => 'manage',
        'description' => 'Full CRUD access to electrician service records',
    ],
];
