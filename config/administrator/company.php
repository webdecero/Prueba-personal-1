<?php

return [
    'model' =>  \App\Models\Company::class,
    'store' =>
    [
        'rules' => [
            'name' => ['required','string'],
            'database' => ['required', 'array'],
            'isMultiLocation' => ['sometimes', 'string'],
            'isGroupActive'=> ['sometimes','string'],
            'metadata' => ['sometimes', 'array'],
        ],
        'autorize' => []
    ],
    'update' =>
    [
        'rules' => [
            'name' => ['required','string'],
            'database' => ['required', 'array'],
            'isMultiLocation' => ['sometimes', 'string'],
            'isGroupActive'=> ['sometimes','string'],
            'metadata' => ['sometimes', 'array'],
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
                'key' => 'metadata.location',
                'operation' => '$eq'
            ],
            [
                'key' => 'status',
                'operation' => '$eq'
            ]
        ]


    ]
];
