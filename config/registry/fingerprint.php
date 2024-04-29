<?php

use Illuminate\Validation\Rule;
use App\Http\Enums\TerminalType;

return [
    'model' =>  \App\Models\Fingerprint::class,
    'store' =>
    [
        'rules' => [
            "userId" => ["required"],
            "typeFinger" => ["required"],
            "typeHand" => ["required"],
            "imageFingerPrint" => ['required', 'file'],
            "templateFingerPrint" => ['required', 'file'],
            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],

            'metadata' => ['sometimes', 'array'],
        ],
        'autorize' => []


    ],
    'update' =>
    [
        'rules' => [
            "userId" => ["required"],
            "typeFinger" => ["required"],
            "typeHand" => ["required"],
            "pathImageFingerPrint" => ['required', 'file'],
            "pathTemplateFingerPrint" => ['required', 'file'],
            'terminalType' => ['required', Rule::enum(TerminalType::class)],
            'terminalKey' => ['required', 'string'],

            'metadata' => ['sometimes', 'array'],
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
