<?php

return [
    'model' =>  Webdecero\Manager\Api\Models\Admin::class,
    'login' =>  [
        'redirectAuth' => '/dashboard'
    ],
    'scopes' =>
    [
        [
            'label' => 'Administradores',
            'description' => 'Grupo de permisos para Administradores',
            'scopes' =>  [
                'admin-show' => 'Ver de Administradores',
                'admin-store' => 'Crear de Administrador',
                'admin-update' => 'Editar de Administrador',
                'admin-delete' => 'Borrar de Administrador',
            ],
        ],
        [
            'label' => 'Usuarios',
            'description' => 'Grupo de permisos para Usuarios',
            'scopes' =>  [
                'user-show' => 'Ver de Usuarios',
                'user-store' => 'Crear de Usuarios',
                'user-update' => 'Editar de Usuarios',
                'user-delete' => 'Borrar de Usuarios',
            ],
        ],

        [
            'label' => 'Huellas',
            'description' => 'Grupo de permisos para Huellas',
            'scopes' =>  [
                'fingerprint-show' => 'Ver de Huellas',
                'fingerprint-store' => 'Crear de Huellas',
                'fingerprint-update' => 'Editar de Huellas',
                'fingerprint-delete' => 'Borrar de Huellas',
            ],
        ],

        [
            'label' => 'Grupos',
            'description' => 'Grupo de permisos para Grupos',
            'scopes' =>  [
                'group-show' => 'Ver de Grupos',
                'group-store' => 'Crear de Grupo',
                'group-update' => 'Editar de Grupo',
                'group-delete' => 'Borrar de Grupo',
            ],
        ],
        [
            'label' => 'Terminales Registry',
            'description' => 'Grupo de permisos para Terminales Registry',
            'scopes' =>  [
                'registry-show' => 'Ver de Terminales Registry',
                'registry-store' => 'Crear de Terminales Registry',
                'registry-update' => 'Editar de Terminales Registry',
                'registry-delete' => 'Borrar de Terminales Registry',
            ],
        ],
        [
            'label' => 'Terminales Kiosks',
            'description' => 'Grupo de permisos para Terminales Kiosks',
            'scopes' =>  [
                'kiosk-show' => 'Ver de Terminales Kiosks',
                'kiosk-store' => 'Crear de Terminales Kiosks',
                'kiosk-update' => 'Editar de Terminales Kiosks',
                'kiosk-delete' => 'Borrar de Terminales Kiosks',
            ],
        ],
        [
            'label' => 'Terminales Torniquete',
            'description' => 'Grupo de permisos para Terminales Torniquete',
            'scopes' =>  [
                'torniquet-show' => 'Ver de Terminales Torniquete',
                'torniquet-store' => 'Crear de Terminales Torniquete',
                'torniquet-update' => 'Editar de Terminales Torniquete',
                'torniquet-delete' => 'Borrar de Terminales Torniquete',
            ],
        ],
        [
            'label' => 'Locaciones',
            'description' => 'Grupo de permisos para Locaciones',
            'scopes' =>  [
                'location-show' => 'Ver de Locaciones',
                'location-store' => 'Crear de Locaciones',
                'location-update' => 'Editar de Locaciones',
                'location-delete' => 'Borrar de Locaciones',
            ],
        ],
        [
            'label' => 'Licencias',
            'description' => 'Grupo de permisos para Licencias',
            'scopes' =>  [
                'license-show' => 'Ver de Licencias',
                'license-update' => 'Editar de Licencias',
            ],
        ],
        [
            'label' => 'Registros accesos',
            'description' => 'Grupo de permisos para Registros accesos',
            'scopes' =>  [
                'access-show' => 'Ver de Registros accesos',
                'access-delete' => 'Borrar de Registros accesos',
            ],
        ],
        [
            'label' => 'Registros Pagos',
            'description' => 'Grupo de permisos para Registros pagos',
            'scopes' =>  [
                'payment-show' => 'Ver de Registros pagos',
                'payment-update' => 'Editar de Registros pagos',
                'payment-delete' => 'Borrar de Registros pagos',
            ],
        ],
        [
            'label' => 'Compañia',
            'description' => 'Grupo de permisos para Compañia',
            'scopes' =>  [
                'company-show' => 'Ver de Compañia',
                'company-update' => 'Editar de Compañia',
            ],
        ],

    ],
    'store' =>
    [
        'rules' => [
            'name' =>  ['required', 'regex:/^[a-zA-Z0-9]+(?:\s+[a-zA-Z0-9]+)*$/'],
            'email' =>  ['required', 'unique:admins,email', 'max:255'],
            'phone' => ['required', 'min:10'],
            'password' => ['required', 'min:5', 'confirmed'],
            'status' => ['required'],
            'avatar' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'attachment' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeFile],
            'scopes' => ['sometimes', 'array'],
            'description' => ['string'],
            'metadata' => ['array']
        ],
        'autorize' => []
    ],
    'update' =>
    [
        'rules' => [
            'name' => ['required', 'regex:/^[a-zA-Z0-9]+(?:\s+[a-zA-Z0-9]+)*$/'],
            'email' => ['required', 'max:255'],
            'phone' => ['min:10'],
            'password' => 'sometimes|min:5|confirmed',
            'status' => ['required'],
            'avatar' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage],
            'attachment' => ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeFile],
            'scopes' => ['sometimes', 'array'],
            'description' => ['string'],
            'metadata' => ['array']
        ],
        'autorize' => []


    ],
    'updatePassword' =>
    [
        'rules' => [
            'password' => ['required', 'min:5', 'confirmed']
        ],

    ],


    'destroy' =>
    [
        'childs' => [],
        'autorize' => []


    ],
    'search' =>
    [
        'except' => ['paginate', 'orderKey', 'orderBy', 'query', 'initDate', 'endDate'],
        'or' =>  [

            [
                'key' => 'name',
                'options' => 'i'
            ],
            [
                'key' => 'email',
                'options' => 'i'
            ],

            [
                'key' => 'phone',
                'options' => 'i'
            ],

        ],
        'and' =>  [

            [
                'key' => 'locations',
                'operation' => '$in'
            ],
            [
                'key' => 'status',
                'operation' => '$eq'
            ]
        ]


    ]
];
