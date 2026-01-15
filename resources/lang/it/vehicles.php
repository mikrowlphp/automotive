<?php

return [
    // Resource labels
    'car_brand' => 'Marca Auto',
    'car_brands' => 'Marche Auto',
    'car_model' => 'Modello Auto',
    'car_models' => 'Modelli Auto',
    'car_variant' => 'Allestimento',
    'car_variants' => 'Allestimenti',
    'vehicle' => 'Veicolo',
    'vehicles' => 'Veicoli',

    // Navigation
    'navigation_group' => 'Automotive',

    // Common fields
    'name' => 'Nome',
    'country' => 'Paese',
    'logo' => 'Logo',
    'status' => 'Stato',
    'active' => 'Attivo',
    'inactive' => 'Inattivo',
    'created_at' => 'Data Creazione',
    'updated_at' => 'Data Modifica',
    'not_specified' => 'Non specificato',
    'present' => 'Oggi',

    // CarBrand fields
    'brand_name' => 'Nome Marca',
    'brand_logo' => 'Logo',
    'brand_country' => 'Paese di Origine',
    'models_count' => 'Numero Modelli',

    // CarBrand sections
    'brand_information' => 'Informazioni Marca',
    'brand_information_desc' => 'Inserisci i dati della marca automobilistica',

    // CarModel fields
    'model_name' => 'Nome Modello',
    'year_from' => 'Anno Inizio Produzione',
    'year_to' => 'Anno Fine Produzione',
    'year_range' => 'Anni Produzione',
    'body_type' => 'Tipo Carrozzeria',
    'variants_count' => 'Numero Allestimenti',
    'vehicles_count' => 'Numero Veicoli',

    // CarModel sections
    'model_information' => 'Informazioni Modello',
    'model_information_desc' => 'Inserisci i dati del modello auto',

    // CarVariant fields
    'variant_name' => 'Nome Allestimento',
    'engine_code' => 'Codice Motore',
    'engine_name' => 'Nome Motore',
    'displacement' => 'Cilindrata',
    'displacement_cc' => 'Cilindrata (cc)',
    'power_kw' => 'Potenza (kW)',
    'power_hp' => 'Potenza (CV)',
    'torque_nm' => 'Coppia (Nm)',
    'transmission' => 'Cambio',
    'doors' => 'Porte',

    // Enum: FuelType
    'fuel_type' => 'Tipo Carburante',
    'fuel_types' => [
        'petrol' => 'Benzina',
        'gasoline' => 'Benzina',
        'diesel' => 'Diesel',
        'electric' => 'Elettrico',
        'hybrid' => 'Ibrido',
        'plugin_hybrid' => 'Ibrido Plug-in',
        'lpg' => 'GPL',
        'cng' => 'Metano',
        'hydrogen' => 'Idrogeno',
    ],

    // Enum: TransmissionType
    'transmission_types' => [
        'manual' => 'Manuale',
        'automatic' => 'Automatico',
        'semi_automatic' => 'Semi-automatico',
        'cvt' => 'CVT',
    ],

    // Enum: BodyType
    'body_types' => [
        'hatchback' => 'Utilitaria',
        'sedan' => 'Berlina',
        'wagon' => 'Station Wagon',
        'suv' => 'SUV',
        'crossover' => 'Crossover',
        'coupe' => 'Coupé',
        'convertible' => 'Cabrio',
        'van' => 'Furgone',
        'pickup' => 'Pick-up',
        'mpv' => 'Monovolume',
        'truck' => 'Camion',
    ],

    // Vehicle fields
    'customer' => 'Cliente',
    'license_plate' => 'Targa',
    'vin' => 'Numero di Telaio (VIN)',
    'color' => 'Colore',
    'year' => 'Anno Immatricolazione',
    'mileage' => 'Chilometraggio',
    'engine' => 'Motore',
    'notes' => 'Note',
    'is_active' => 'Attivo',
    'car_info' => 'Auto',

    // Vehicle sections
    'vehicle_information' => 'Informazioni Veicolo',
    'vehicle_identification' => 'Identificazione Veicolo',
    'vehicle_identification_desc' => 'Inserisci i dati di identificazione del veicolo',
    'technical_details' => 'Dettagli Tecnici',
    'additional_information' => 'Informazioni Aggiuntive',
    'customer_information' => 'Informazioni Cliente',
    'engine_information' => 'Informazioni Motore',
    'production_years' => 'Anni di Produzione',

    // Actions
    'create_brand' => 'Nuova Marca',
    'create_model' => 'Nuovo Modello',
    'create_variant' => 'Nuovo Allestimento',
    'create_vehicle' => 'Nuovo Veicolo',
    'edit_brand' => 'Modifica Marca',
    'edit_model' => 'Modifica Modello',
    'edit_variant' => 'Modifica Allestimento',
    'edit_vehicle' => 'Modifica Veicolo',
    'view_services' => 'Visualizza Interventi',
    'view_variants' => 'Visualizza Allestimenti',

    // Filters
    'filter_status' => 'Filtra per Stato',
    'filter_brand' => 'Filtra per Marca',
    'filter_body_type' => 'Filtra per Carrozzeria',
    'filter_fuel_type' => 'Filtra per Carburante',
    'filter_customer' => 'Filtra per Cliente',

    // Messages
    'no_models' => 'Nessun modello disponibile',
    'no_variants' => 'Nessun allestimento disponibile',
    'select_brand_first' => 'Seleziona prima una marca',
    'select_model_first' => 'Seleziona prima un modello',
    'vehicle_has_services' => 'Impossibile eliminare: il veicolo ha interventi registrati',
    'brand_has_models' => 'Impossibile eliminare: la marca ha modelli associati',
    'model_has_vehicles' => 'Impossibile eliminare: il modello ha veicoli associati',
    'model_has_variants' => 'Impossibile eliminare: il modello ha allestimenti associati',
    'variant_has_vehicles' => 'Impossibile eliminare: l\'allestimento ha veicoli associati',

    // Placeholders
    'select_brand' => 'Seleziona una marca...',
    'select_model' => 'Seleziona un modello...',
    'select_variant' => 'Seleziona un allestimento...',
    'select_fuel_type' => 'Seleziona tipo carburante...',
    'select_transmission' => 'Seleziona cambio...',
    'select_body_type' => 'Seleziona tipo carrozzeria...',
    'vin_placeholder' => 'Es. WVWZZZ3CZWE123456',
    'engine_placeholder' => 'Es. 1.6 TDI 115 CV',
    'notes_placeholder' => 'Note aggiuntive sul veicolo...',

    // Helper text
    'is_active_help' => 'I veicoli disattivati non appariranno nelle selezioni',
];
