<?php

return [
    'app' => [
        'title' => 'Allmänt',
        'desc' => 'Allmänna inställningar för applikationen.',
        'icon' => 'settings_applications',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'app_name', // unique name for field
                'label' => 'App Name', // you know what label it is
                'rules' => 'required|min:2|max:50', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Intranet' // default value if you want
            ],
        ]
    ],
    'modules' => [
        'title' => 'Moduler',
        'desc' => 'Aktivera moduler för användare. Oaktiverade moduler visas för rollen "beta"',
        'icon' => 'dashboard',

        'elements' => [
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'enable_issues', // unique name for field
                'label' => 'Ärenden', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 0 // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'enable_dokument', // unique name for field
                'label' => 'Dokument', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 0 // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'enable_visitors', // unique name for field
                'label' => 'Besökare', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 0 // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'enable_demoprodukter', // unique name for field
                'label' => 'Demoprodukter', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 0 // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'enable_posts', // unique name for field
                'label' => 'Artiklar', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 0 // default value if you want
            ],
        ]
    ],
    'email' => [
        'title' => 'Email',
        'desc' => 'Inställningar för email.',
        'icon' => 'mail',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'app_from_name', // unique name for field
                'label' => 'Från namn', // you know what label it is
                'rules' => 'required|min:2|max:50', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'Carlo Gavazzi' // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'app_from_adress', // unique name for field
                'label' => 'Från mailadress', // you know what label it is
                'rules' => 'required|email', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'support@carlogavazzi.se' // default value if you want
            ],
        ]
    ],
    'module_settings_issue' => [
        'title' => 'Ärenden',
        'desc' => 'Inställningar för ärenden',
        'icon' => 'settings_applications',

        'elements' => [
            [
                'type' => 'text', // input fields type
                'data' => 'string', // data type, string, int, boolean
                'name' => 'issue_prefix', // unique name for field
                'label' => 'Ärendenummer byggs av "prefix" + ÅÅxxx, xxx är löpnummer per år', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 'S-' // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'int', // data type, string, int, boolean
                'name' => 'time_disable_update_job', // unique name for field
                'label' => 'Fördröjning av mail av "Nytt ärende" vid direktutcheckning (minuter)', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '15' // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'int', // data type, string, int, boolean
                'name' => 'time_reminder_urgent_issue', // unique name for field
                'label' => 'Fördröjning av påminnelsemail vid BRÅDSKANDE ärenden (minuter)', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '30' // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'int', // data type, string, int, boolean
                'name' => 'days_reminder_paused_issue', // unique name for field
                'label' => 'Fördröjning av notifiering vid pausade ärenden (dagar)', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '7' // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'int', // data type, string, int, boolean
                'name' => 'days_reminder_waiting_for_external', // unique name for field
                'label' => 'Fördröjning av notifiering av saknat svar från kund (dagar)', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '7' // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'int', // data type, string, int, boolean
                'name' => 'days_reminder_waiting_for_internal', // unique name for field
                'label' => 'Fördröjning av notifiering av saknat svar från kollega (dagar)', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '2' // default value if you want
            ],
            [
                'type' => 'text', // input fields type
                'data' => 'int', // data type, string, int, boolean
                'name' => 'minutes_checkin', // unique name for field
                'label' => 'Checka tillbaks ärende när användare varit inaktiv på intranätet i (min)', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => '60' // default value if you want
            ],
        ]
    ],
];