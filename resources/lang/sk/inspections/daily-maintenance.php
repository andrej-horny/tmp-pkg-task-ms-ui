<?php

return [
    'create_heading' => 'Vytvoriť denné ošetrenie',
    'list_heading' => 'Denné ošetrenie',
    'update_heading' => 'Upraviť denné ošetrenie: :title',
    'form' => [
        'fields' => [
            'date' => 'Dátum',
            'vehicles' => 'Vozidlá',
            'template' => 'Typ ošetrenia',
            'contracts' => 'Zamestnanci',
            'assigned_to' => [
                'label' => 'Domovská technická prevádzka',
                'hint' => 'Domovská technická prevádzka'
            ],
            'activity_templates' => 'Činnosti / normy',
        ],
        'sections' => [
            'vehicles' => 'Vozidlá',
            'contracts' => 'Zamestnanci',
            'activity_templates' => 'Činnosti / normy',
       ]
    ],
    'table' => [
        'heading' => 'Denné ošetrenie',
        'empty_state_heading' => 'Žiadne denné ošetrenie na zobrazenie',
        'columns' => [
            'date' => 'Dátum',
            'subject' => 'Vozidlá',
            'template' => 'Typ ošetrenia',
            'state' => 'Stav',
            'note' => 'Poznámka',
            'assigned_to' => 'Prevádzka',
            'contracts' => 'Vykonal',
            'total_time' => 'Celkový čas'
        ],
        'filters' => [
            'date' => 'Dátum',
            'subject' => 'Vozidlá',
            'template' => 'Typ ošetrenia',
            'state' => 'Stav',
            'maintenance_group' => 'Prevádzka',
        ],
        'actions' => [
            'create_daily_maintenance' => 'Vytvoriť'
        ]
    ],
    'navigation' => [
        'label' => 'Denné ošetrenie',
        'group' => 'Kontroly',
    ],
    'resource' => [
        'model_label' => 'Denné ošetrenie',
        'plural_model_label' => 'Denné ošetrenie',
    ],
];