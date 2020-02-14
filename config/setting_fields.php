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
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'enable_issues', // unique name for field
                'label' => 'Aktivera Ärenden för användare', // you know what label it is
                'rules' => 'required', // validation rule of laravel
                'class' => '', // any class for input
                'value' => 0 // default value if you want
            ],
            [
                'type' => 'checkbox', // input fields type
                'data' => 'boolean', // data type, string, int, boolean
                'name' => 'enable_produkter', // unique name for field
                'label' => 'Aktivera Produkter för användare', // you know what label it is
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
];