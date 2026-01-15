<?php

return [
    // ============================================
    // DIAGNOSIS RESOURCE
    // ============================================
    'diagnosis' => [
        'singular' => 'Accettazione',
        'plural' => 'Accettazioni',
        'vehicle_customer_info' => 'Veicolo e Cliente',
        'vehicle_customer_info_desc' => 'Informazioni sul veicolo e il proprietario',
        'acceptance_date' => 'Data Accettazione',
        'mileage_at_acceptance' => 'Chilometraggio all\'Accettazione',
        'diagnosis_info' => 'Informazioni Diagnosi',
        'customer_complaint' => 'Problema Segnalato',
        'customer_complaint_placeholder' => 'Descrivi il problema segnalato dal cliente...',
        'initial_diagnosis' => 'Diagnosi Iniziale',
        'initial_diagnosis_placeholder' => 'Inserisci la diagnosi preliminare...',
        'status' => 'Stato',
        'notes' => 'Note',
        'notes_placeholder' => 'Note aggiuntive...',
        'service_records_count' => 'Interventi',
    ],

    // Diagnosis statuses
    'diagnosis_statuses' => [
        'draft' => 'Bozza',
        'open' => 'Aperta',
        'closed' => 'Chiusa',
    ],

    // ============================================
    // DASHBOARD
    // ============================================
    'dashboard' => [
        'open_diagnoses' => 'Accettazioni Aperte',
        'waiting_evaluation' => 'In attesa di valutazione',
        'in_progress' => 'In Lavorazione',
        'services_in_progress' => 'Interventi in corso',
        'scheduled' => 'Programmati',
        'waiting_to_start' => 'In attesa di iniziare',
        'completed_month' => 'Completati',
        'this_month' => 'Questo mese',
        'total_vehicles' => 'Veicoli Totali',
        'registered_vehicles' => 'Veicoli registrati',
        'quick_actions' => 'Azioni Rapide',
        'new_diagnosis' => 'Nuova Accettazione',
        'new_vehicle' => 'Nuovo Veicolo',
    ],

    // ============================================
    // SERVICE RECORD RESOURCE
    // ============================================
    // Resource labels
    'service_record' => 'Intervento',
    'service_records' => 'Interventi',
    'service_line' => 'Riga Intervento',
    'service_lines' => 'Righe Intervento',

    // Navigation
    'navigation_group' => 'Automotive',

    // Common fields
    'created_at' => 'Data Creazione',
    'updated_at' => 'Data Modifica',
    'not_specified' => 'Non specificato',
    'days' => 'giorni',

    // Service types
    'types' => [
        'mechanics' => 'Meccanica',
        'mechanics_plural' => 'Interventi Meccanica',
        'bodywork' => 'Carrozzeria',
        'bodywork_plural' => 'Interventi Carrozzeria',
        'tires' => 'Gomme',
        'tires_plural' => 'Interventi Gomme',
        'electrician' => 'Elettrauto',
        'electrician_plural' => 'Interventi Elettrauto',
    ],

    // ServiceRecord fields
    'vehicle' => 'Veicolo',
    'customer' => 'Cliente',
    'service_date' => 'Data Intervento',
    'mileage_at_service' => 'Chilometraggio',
    'mileage' => 'Chilometraggio',
    'status' => 'Stato',
    'statuses' => [
        'draft' => 'Bozza',
        'in_progress' => 'In Corso',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
    ],
    'customer_complaint' => 'Problema Segnalato dal Cliente',
    'notes' => 'Note',
    'total_amount' => 'Totale',

    // ServiceRecordLine fields
    'line_type' => 'Tipo',
    'line_types' => [
        'labor' => 'Manodopera',
        'part' => 'Ricambio',
        'other' => 'Altro',
    ],
    'description' => 'Descrizione',
    'quantity' => 'Quantità',
    'unit_price' => 'Prezzo Unitario',
    'line_total' => 'Totale Riga',
    'part' => 'Ricambio',
    'add_part' => 'Aggiungi Ricambio',
    'note' => 'Nota',

    // Sections
    'service_information' => 'Informazioni Intervento',
    'service_information_desc' => 'Inserisci i dettagli dell\'intervento',
    'service_details' => 'Dettagli Intervento',
    'problem_and_diagnosis' => 'Problema e Diagnosi',
    'financial_summary' => 'Riepilogo Economico',
    'lines' => 'Righe Intervento',

    // Placeholders
    'customer_complaint_placeholder' => 'Descrivi il problema segnalato dal cliente...',
    'diagnosis_placeholder' => 'Inserisci la diagnosi del tecnico...',
    'notes_placeholder' => 'Note aggiuntive sull\'intervento...',

    // Helper text
    'total_amount_help' => 'Calcolato automaticamente dalle righe intervento',

    // Actions
    'create_service' => 'Nuovo Intervento',
    'edit_service' => 'Modifica Intervento',
    'add_line' => 'Aggiungi Riga',
    'complete_service' => 'Completa Intervento',
    'cancel_service' => 'Annulla Intervento',

    // Filters
    'filter_status' => 'Filtra per Stato',
    'filter_vehicle' => 'Filtra per Veicolo',
    'filter_customer' => 'Filtra per Cliente',

    // Messages
    'cannot_edit_completed' => 'Impossibile modificare un intervento completato',
    'cannot_delete_completed' => 'Impossibile eliminare un intervento completato',
    'only_draft_deletable' => 'Solo gli interventi in bozza possono essere eliminati',
    'vehicle_required' => 'Seleziona un veicolo',
    'customer_auto_filled' => 'Cliente auto-compilato dal veicolo',

    // Summary
    'total_labor' => 'Totale Manodopera',
    'total_parts' => 'Totale Ricambi',
    'total_other' => 'Totale Altro',
    'grand_total' => 'Totale Generale',

    // Settings
    'settings' => [
        'heading' => 'Impostazioni Servizi',
        'navigation_label' => 'Servizi',
        'service_types' => [
            'title' => 'Tipologie di Intervento',
            'description' => 'Abilita o disabilita specifiche tipologie di intervento per la tua attività',
            'mechanics' => 'Meccanica',
            'mechanics_help' => 'Manutenzione generale e riparazioni veicoli',
            'bodywork' => 'Carrozzeria',
            'bodywork_help' => 'Riparazioni carrozzeria, verniciatura e lavori post-collisione',
            'tires' => 'Gomme',
            'tires_help' => 'Installazione, equilibratura e rotazione pneumatici',
            'electrician' => 'Elettrauto',
            'electrician_help' => 'Sistemi elettrici, diagnostica e riparazioni',
        ],
    ],

    // ============================================
    // MECHANICS SERVICE TYPE
    // ============================================
    'mechanics' => [
        'parameters' => 'Parametri Meccanica',
        'parameters_desc' => 'Dettagli specifici per interventi di meccanica',
        'labor_hours' => 'Ore di Lavoro',
        'work_type' => 'Tipo di Lavoro',
        'work_types' => [
            'maintenance' => 'Manutenzione ordinaria',
            'repair' => 'Riparazione',
            'inspection' => 'Ispezione',
            'overhaul' => 'Revisione',
        ],
        'diagnosis' => 'Diagnosi',
        'diagnosis_placeholder' => 'Inserisci la diagnosi del problema...',
        'work_performed' => 'Lavoro Effettuato',
        'work_performed_placeholder' => 'Descrivi il lavoro eseguito...',
        'parts_replaced' => 'Ricambi Sostituiti',
        'part_name' => 'Nome Ricambio',
        'part_quantity' => 'Quantità',
        'add_part' => 'Aggiungi Ricambio',
        'search_part' => 'Cerca ricambio per marca o modello...',
    ],

    // ============================================
    // BODYWORK SERVICE TYPE
    // ============================================
    'bodywork' => [
        'parameters' => 'Parametri Carrozzeria',
        'parameters_desc' => 'Dettagli specifici per interventi di carrozzeria',
        'damage_areas' => 'Zone Danneggiate',
        'areas' => [
            'front_bumper' => 'Paraurti Anteriore',
            'rear_bumper' => 'Paraurti Posteriore',
            'hood' => 'Cofano',
            'trunk' => 'Bagagliaio',
            'roof' => 'Tetto',
            'left_front_door' => 'Portiera Anteriore Sinistra',
            'left_rear_door' => 'Portiera Posteriore Sinistra',
            'right_front_door' => 'Portiera Anteriore Destra',
            'right_rear_door' => 'Portiera Posteriore Destra',
            'left_fender' => 'Parafango Sinistro',
            'right_fender' => 'Parafango Destro',
            'left_quarter_panel' => 'Passaruota Sinistro',
            'right_quarter_panel' => 'Passaruota Destro',
        ],
        'repair_type' => 'Tipo di Riparazione',
        'repair_types' => [
            'dent_repair' => 'Riparazione Ammaccatura',
            'scratch_repair' => 'Riparazione Graffi',
            'partial_repaint' => 'Verniciatura Parziale',
            'full_repaint' => 'Verniciatura Completa',
            'panel_replacement' => 'Sostituzione Pannello',
        ],
        'paint_type' => 'Tipo di Vernice',
        'paint_types' => [
            'solid' => 'Tinta Unita',
            'metallic' => 'Metallizzata',
            'pearl' => 'Perlata',
            'matte' => 'Opaca',
        ],
        'paint_code' => 'Codice Vernice',
        'estimated_days' => 'Giorni Stimati',
        'insurance_claim' => 'Sinistro Assicurazione',
        'insurance_claim_placeholder' => 'Numero pratica assicurazione...',
        'damage_description' => 'Descrizione Danno',
        'parts_used' => 'Ricambi Utilizzati',
        'search_part' => 'Cerca ricambio per marca o modello...',
    ],

    // ============================================
    // TIRE SERVICE TYPE
    // ============================================
    'tires' => [
        'parameters' => 'Parametri Pneumatici',
        'parameters_desc' => 'Dettagli specifici per interventi su pneumatici',
        'is_two_wheeler' => 'Veicolo a 2 Ruote',
        'is_two_wheeler_help' => 'Attiva se si tratta di moto, scooter o ciclomotore',
        'service_type' => 'Tipo di Intervento',
        'service_types' => [
            'replacement' => 'Sostituzione',
            'rotation' => 'Rotazione',
            'balancing' => 'Equilibratura',
            'alignment' => 'Convergenza',
            'repair' => 'Riparazione',
            'seasonal_change' => 'Cambio Stagionale',
        ],
        'tire_season' => 'Stagione Pneumatico',
        'seasons' => [
            'summer' => 'Estivo',
            'winter' => 'Invernale',
            'all_season' => 'Quattro Stagioni',
        ],
        'positions_label' => 'Posizioni',
        'position' => 'Posizione',
        'positions' => [
            'front_left' => 'Anteriore Sinistro',
            'front_right' => 'Anteriore Destro',
            'rear_left' => 'Posteriore Sinistro',
            'rear_right' => 'Posteriore Destro',
            'front' => 'Anteriore',
            'rear' => 'Posteriore',
        ],
        'tire_details' => 'Dettagli Pneumatici',
        'brand' => 'Marca',
        'model' => 'Modello',
        'size' => 'Misura',
        'size_help' => 'Formato: larghezza/altezza R diametro (es. 225/45R17)',
        'load_index' => 'Indice di Carico',
        'speed_index' => 'Indice di Velocità',
        'dot' => 'DOT (Settimana/Anno)',
        'dot_help' => 'Le ultime 4 cifre indicano settimana e anno di produzione',
        'tread_depth' => 'Profondità Battistrada',
        'load_speed' => 'Indice Carico/Velocità',
        'tire_product' => 'Pneumatico',
        'search_tire' => 'Cerca per marca o modello...',
        'store_old_tires' => 'Deposito Pneumatici Vecchi',
        'store_old_tires_help' => 'Attiva se il cliente lascia i pneumatici in deposito',
        'storage_location' => 'Posizione Deposito',
        'storage_location_placeholder' => 'Es. Scaffale A3, Box 15...',
    ],

    // ============================================
    // ELECTRICIAN SERVICE TYPE
    // ============================================
    'electrician' => [
        'parameters' => 'Parametri Elettrauto',
        'parameters_desc' => 'Dettagli specifici per interventi elettrici',
        'system_area' => 'Area di Sistema',
        'areas' => [
            'engine_management' => 'Gestione Motore',
            'starting_system' => 'Sistema di Avviamento',
            'charging_system' => 'Sistema di Ricarica',
            'lighting' => 'Illuminazione',
            'sensors' => 'Sensori',
            'infotainment' => 'Infotainment',
            'climate_control' => 'Climatizzatore',
            'safety_systems' => 'Sistemi di Sicurezza',
            'wiring' => 'Cablaggio',
            'other' => 'Altro',
        ],
        'service_type' => 'Tipo di Intervento',
        'service_types' => [
            'diagnosis' => 'Diagnosi',
            'repair' => 'Riparazione',
            'replacement' => 'Sostituzione',
            'installation' => 'Installazione',
            'programming' => 'Programmazione',
        ],
        'diagnostic_codes' => 'Codici Diagnostici',
        'diagnostic_codes_placeholder' => 'Es. P0300, P0171, B1234...',
        'diagnostic_codes_help' => 'Inserisci i codici errore OBD rilevati (uno per riga)',
        'components_tested' => 'Componenti Testati',
        'components' => [
            'battery' => 'Batteria',
            'alternator' => 'Alternatore',
            'starter' => 'Motorino Avviamento',
            'fuses' => 'Fusibili',
            'relays' => 'Relè',
            'wiring_harness' => 'Cablaggio',
            'ecu' => 'Centralina (ECU)',
            'sensors' => 'Sensori',
            'actuators' => 'Attuatori',
        ],
        'battery_status' => 'Stato Batteria',
        'battery_voltage' => 'Tensione Batteria',
        'battery_cca' => 'CCA (Corrente Spunto)',
        'battery_cca_help' => 'Cold Cranking Amps - Corrente di spunto a freddo',
        'battery_health' => 'Stato di Salute',
        'battery_condition' => 'Condizione',
        'conditions' => [
            'good' => 'Buona',
            'fair' => 'Discreta',
            'weak' => 'Debole',
            'replace' => 'Da Sostituire',
        ],
        'firmware_update_required' => 'Aggiornamento Firmware Richiesto',
        'firmware_update_help' => 'La centralina necessita di aggiornamento software',
        'work_performed' => 'Lavoro Effettuato',
        'parts_used' => 'Ricambi Utilizzati',
        'search_part' => 'Cerca ricambio per marca o modello...',
    ],
];
