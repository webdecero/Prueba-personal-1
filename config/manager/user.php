<?php

return [
    'model' =>  \App\Models\User::class,
    'store' =>
    [
        'rules' => [
            'name' => ['sometimes', 'string'],
            'email' => ['requerid', 'email', 'unique:users,email'],
            'password' => ['sometimes','string'],
            'image' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage ],
            'status' => ['sometimes', 'string'],
            'address' => ['sometimes', 'string'],
            'phone' => ['sometimes','string'],
            'locations' => ['sometimes', 'array'],
            'metadata' => ['sometimes','array'],
            //'parentModelClass' => ['sometimes','String'],
            //'parentModelIndex' => ['sometimes','string'],
            //'parentModel_id' => ['sometimes','string'],
            //'company_key' => ['sometimes','string'],
            //'company_name' => ['sometimes','string'],
            //'terminal_key' => ['sometimes','string'],
            //'terminal_name' => ['sometimes','string'],
            //'terminal_type' => ['sometimes','string'],
        ],
        'autorize' => []


    ],
    'update' =>
    [
        'rules' => [
            'name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'string', 'unique'],
            'password' => ['sometimes','string'],
            'image' =>  ['sometimes', 'array', new Webdecero\Package\Core\Rules\RuleTypeImage ],
            'status' => ['sometimes', 'string'],
            'address' => ['sometimes', 'string'],
            'phone' => ['sometimes','string'],
            'locations' => ['sometimes', 'array'],
            'metadata' => ['sometimes','array'],
        ],
        'autorize' => []


    ],
    'destroy' =>
    [
        'childs' => [
        ],
        'autorize' => []


    ],
    'search' =>
    [
        'except' =>['paginate', 'orderKey', 'orderBy', 'query', 'initDate', 'endDate'],
        'or' =>  [

            [
                'key' => 'name',
                'options' => 'i'
            ]
        ],
        'and' =>  [

            [
                'key' => 'locations',
                'operation' => '$eq'
            ],
            [
                'key' => 'status',
                'operation' => '$eq'
            ]
        ]


    ]
];
