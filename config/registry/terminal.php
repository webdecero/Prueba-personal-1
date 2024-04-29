<?php

// use Illuminate\Validation\Rule;
// use App\Http\Enums\TerminalType;

return [
    'model' =>  \App\Models\Registry::class,
    'setup' =>
    [
        'rules' => [
            "deviceId" => ["required"],
            "terminalKey" => ["required"],
            "version" => ["required"]
        ],
        'autorize' => []

    ],
    'update' =>
    [
        'rules' => [
            "deviceId" => ["required"],
            "terminalKey" => ["required"],
            "version" => ["required"]
        ],
        'autorize' => []


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
                'key' => 'locationName',
                'options' => 'i'
            ]
        ],
        'and' =>  [

            [
                'key' => 'location_key',
                'operation' => '$eq'
            ],
            [
                'key' => 'terminal_key',
                'operation' => '$eq'
            ],
            [
                'key' => 'user_id',
                'operation' => '$eq'
            ]
        ]


    ]
];
